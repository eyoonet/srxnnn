<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/6
 * Time: 0:55
 */
namespace app\api\model;

use think\Model;
use think\helper\Time;

class Task extends Model
{
    public $error;
    protected $autoWriteTimestamp = true;
    protected $type = [
        'task_time' => 'timestamp:Y-m-d H:i',
        'finish_time' => 'timestamp:Y-m-d H:i',
    ];

    /** **********************************************模型关联开始******************************************* */
    public function objdata()
    {
        /** 一对一关联data */
        return $this->hasOne('Data', 'id', 'data_id');
    }

    public function template()
    {
        /** 一对一关联任务模板 */
        return $this->hasOne('TaskTemplate', 'id', 'template_id');
    }

    /** **********************************************模型关联结束******************************************* */

    // 全局查询范围
    protected static function base($query)
    {
        // 查询状态为1的数据
        $query->view('task', 'id,template_id,status,se_id,re_id,contnet,reply_text,reply_image,create_time,task_time,finish_time,finish,data_id')
            ->view('task_template temp', 'title', 'task.template_id = temp.id')
            ->view('user A', 'user_name as se_name', 'task.se_id = A.id', 'LEFT')
            ->view('user B', 'user_name as re_name', 'task.re_id = B.id', 'LEFT')
            ->view('data', 'name as clents_name', 'task.data_id=data.id', 'LEFT');
    }

    /** **********************************************查询开始******************************************* */
    /**
     * 时间表达式查询
     * @param $params  分页参数
     * @param $rule    条件规则
     * @param $fieids  绑定数据
     * @param $time    时间表达式    today今天  yesterday昨天
     * @return array|\PDOStatement|string|\think\Collection
     */
    public function ListByTime($params, $rule, $fieids, $time)
    {
        $lists = $this
            ->order($params['sort'], $params['order'])
            ->page($params['page'], $params['rows'])
            ->whereTime('task.task_time', $time)
            ->where($rule, $fieids)
            ->select();
        $total = $this
            ->whereTime('task.task_time', $time)
            ->where($rule, $fieids)
            ->count();
        return array(
            'rows' => $lists, 'total' => $total
        );
    }

    /**
     * 带分页排序获取任务列表
     * @param $params  分页排序的数组 array(sort,order,page,rows)
     * @param $rule    查询规则
     * @param $fieids  规则绑定字段
     * @return array|\PDOStatement|string|\think\Collection
     */
    public function List($params, $rule, $fieids)
    {
        $lists = $this
            ->order($params['sort'], $params['order'])
            ->page($params['page'], $params['rows'])
            ->where($rule, $fieids)
            ->select();
        $total = $this
            ->where($rule, $fieids)
            ->count();
        return array(
            'rows' => $lists, 'total' => $total
        );
    }

    /**
     * 带分页排序的过期未处理的任务列表.
     * @param $params  分页排序的数组 array(sort,order,page,rows)
     * @param $rule    查询规则
     * @param $fieids  规则绑定字段
     * @return array|\PDOStatement|string|\think\Collection
     */
    public function overdue($params, $rule, $fieids)
    {
        list($start, $end) = Time::today();// 今日开始和结束的时间戳
        $lists = $this
            ->order($params['sort'], $params['order'])
            ->page($params['page'], $params['rows'])
            ->where($rule, $fieids)
            ->where('task.task_time', '<= time', $start)
            ->select();
        $total = $this
            ->where($rule, $fieids)
            ->where('task.task_time', '<= time', $start)
            ->count();
        return array(
            'rows' => $lists, 'total' => $total
        );
    }


    /**
     * 搜索数据
     * @post @date_type int
     * @powt @date array
     * @param $params array 排序分页参数
     * @param $array
     * @return array|\PDOStatement|string|\think\Collection
     */
    public function search($params, $array)
    {
        //表达式定义
        $exps = ["eq" => [], "like" => [], "in" => [], "between time" => [],
        ];
        //日期字段,对应html type 的 value
        $datekeys = [0 => 'add_time', 1 => 'I_date', 2 => 'II_date', 3 => 'speed_time'];
        if (isset($array['date_type'])) {
            $type = $array['date_type'];// 等于数字
            $datepk = $datekeys[$type];
            $array[$datepk] = $array['date'];
            unset($array['date_type']);
            unset($array['date']);
        }
        //map条件组装.
        $map = array();
        while ($value = current($array)) {
            $key = key($array);
            $exp = $this->exp($exps, $key);
            if ($exp == null) $exp = "=";
            if ($exp == "like") $value = "%" . $value . "%";
            $map[] = ['task.' . $key, $exp, $value];
            next($array);
        }
        $lists = $this->where('order', 1)
            ->order($params['sort'], $params['order'])
            ->page($params['page'], $params['rows'])
            ->where($map)
            ->select();
        $total = $this
            ->where($map)
            ->count();
        return array(
            'rows' => $lists, 'total' => $total
        );
    }
    /** **********************************************查询结束******************************************* */


    /** **********************************************业务逻辑开始**************************************** */


    /**
     * 创建任务
     * @param INT $uid 用户ID
     * @param INT $data_id 客户ID
     * @param Array $post
     * @return bool
     */
    public function add($uid, $data_id, $post)
    {
        $post['se_id'] = $uid;
        $post['data_id'] = $data_id;

        $data = $this->objdata()->get($data_id);
        if ($post['template_id'] == self::SIGN || $post['template_id'] == self::SUBMIT || $post['template_id'] == self::GET_DIAOLING) {
            switch ($post['template_id']) {
                case self::SIGN:
                    if ($data->getData('speed') != -1) {
                        $this->error = '当前任务与客户进度不符合';
                        return false;
                    }
                    break;
                case self::SUBMIT:
                    if ($data->getData('speed') != 1) {
                        $this->error = '当前任务与客户进度不符合';
                        return false;
                    }
                    break;
            }
            $data->rcdate = $post['task_time'];
            $data->wuser_id = $post['re_id'];
            $data->status = 100;//派单外勤
            if (!$data->save()) {
                $this->error = '派单出错!..DATA更新失败..';
                return false;
            }
        }

        return $this->save($post) ? true : false;
    }


    /** 任务处理逻辑 */
    public function dispose($post)
    {
        $newobj = new Task();
        $newds = $this->getnews();
        //checked
        if ($post['finish'] == 'success') {

            $this->finish = true;
            if ($this->template->success_evnet_id != null) {
                //执行成功的事件
                $newobj->saveAll($newds['success']);
            }
            if ($this->template->success_ext_evnet != null) {
                //执行成功扩展函数
                $fun = $this->template->success_ext_evnet;
                $this->objdata->$fun();
            }

        } else {

            $this->finish = false;
            if ($this->template->failed_evnet_id != null) {
                //执行失败事件
                $newobj->saveAll($newds['failed']);
            }
            if ($this->template->failed_ext_evnet != null) {
                //执行失败扩展函数
                $fun = $this->template->failed_ext_evnet;
                $this->objdata->$fun();
            }
        }
        $this->status = 2;//处理
        $this->finish_time = time();
        return $this->save();
    }

    /** 任务处理的数据验证 */
    public function dispose_validate($post, $uid)
    {
        /*if ($this->getData('status') != 1) {
            $this->error = '当前任务已经处理,请勿重复提交!';
            return false;
        }*/
        if ($uid != 1) {
            if ($this->re_id != $uid) {
                $this->error = '当前任务执行者不符!';
                return false;
            }
        }
        if ($this->getData('reply_text') == 'checked') {
            if (empty($post['reply_text'])) {
                $this->error = '发布者需要您写点文字反馈';
                return false;
            } else {
                //老任务回馈需要写入.
                $this->reply_text = $post['reply_text'];
            }
        }

        if ($this->getData('reply_image') == 'checked') {
            if (empty($post['reply_image'])) {
                $this->error = '发布者需要您上传图片回馈';
                return false;
            }
        }
        return true;
    }


    public function getnews()
    {
        $success_evnets = $this->template()
            ->where('id', 'in', $this->template->success_evnet_id)
            ->field('id,re_group,time,reply_text,reply_image')
            ->select();
        $failed_evnets = $this->template()
            ->where('id', 'in', $this->template->failed_evnet_id)
            ->field('id,re_group,time,reply_text,reply_image')
            ->select();
        $this->FormatTask($success_evnets);
        $this->FormatTask($failed_evnets);
        $res = ['success' => $success_evnets, 'failed' => $failed_evnets];

        return $res;
    }


    private function FormatTask(&$evnets)
    {
        $temp = array();
        foreach ($evnets as &$itme) {
            switch ($itme->re_group) {
                case 1:
                    $itme->re_id = 1;
                    break;
                case 2:
                    $itme->re_id = $this->objdata->user_id;
                    break;
                case 3:
                    $itme->re_id = $this->objdata->nuser_id;
                    break;
                case 4:
                    $itme->re_id = $this->objdata->wuser_id;
                    break;
            }
            $itme->data_id = $this->objdata->id;
            $itme->se_id = 10000;
            $itme->template_id = $itme->id;
            if ($itme->time == null) {
                $time = time();
            } else {
                $time = Time::daysAfter($itme->time);
            }
            $itme->task_time = $time;
            unset($itme->re_group);
            unset($itme->id);
            unset($itme->time);
            $temp[] = $itme->getData();
        }
        $evnets = $temp;
    }


    /** **********************************************业务逻辑结束**************************************** */


    /** **********************************************辅助开始******************************************* */
    /**
     * 就是返回数组格式为 不知道相同值会不会有问题
     * [
     *   "eq"      => ['name','tel'],
     *   "like"    => ['111'],
     *   "in"      => ['222'],
     *   "between" => ['333']
     * ]
     * @param $exps
     * @param $key
     * @return mixed
     */
    private function exp($exps, $key)
    {
        foreach ($exps as $expp) {
            $expskey = array_search($expp, $exps);//获取value 为 $expp 的 key
            foreach ($expp as $val) {
                if ($key == $val) {
                    return $expskey;
                }
            }
        }
    }


    /** **********************************************辅助结束******************************************* */


    /** **********************************************模型常量定义开始******************************************* */
    const SIGN = 1;//一审
    const SUBMIT = 2;//已二审
    const GET_DIAOLING = 3;//拿调令
    const BACK_SIGN = 5;//一审回访
    const BACK_SUBMIT = 6;//二审回访
    const BACK_DIAOLIN = 7;//拿调令回访
    const APPOINTMENT = 8; //约号
    const CAN_MOVE = 9; //准迁
    const SETTLE = 10;//落户
    const SUBMIT_DATA = 11;//准备二审材料
    const APPOINTMENT_CLIENT = 12;//约客户
    /** **********************************************模型常量结束******************************************* */


    /** **********************************************获取器开始******************************************* */

    public function getStatusAttr($key)
    {
        $data = [
            1 => '进行中',
            2 => '已处理',
            3 => '转发',
            -1 => '撤回',
        ];
        return isset($data[$key]) ? $data[$key] : "未知";
    }


    public function getReplyTextAttr($name)
    {
        return $name == 'checked' ? '' : $name;
    }
    /** **********************************************获取器结束******************************************* */
}