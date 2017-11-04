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
    protected $autoWriteTimestamp = true;
    protected $type = [
        'task_time' => 'timestamp:Y-m-d H:i',
        'finish_time' => 'timestamp:Y-m-d H:i',
        'Tag' => 'json',
    ];

    // 全局查询范围
    protected static function base($query)
    {
        // 查询状态为1的数据
        $query->view('task', 'id,type,title,comments,create_time,task_time,finish_time,finish_type,clents_id,error,Tag')
            ->view('user A', 'user_name as se_name', 'task.se_by_id = A.id', 'LEFT')
            ->view('user B', 'user_name as re_name', 'task.re_by_id = B.id', 'LEFT')
            ->view('data', 'name as clents_name', 'task.clents_id=data.id', 'LEFT');
    }
    /**
     * 时间表达式查询
     * @param $params  分页参数
     * @param $rule    条件规则
     * @param $fieids  绑定数据
     * @param $time    时间表达式    today今天  yesterday昨天
     * @return array|\PDOStatement|string|\think\Collection
     */
    public function ListByTime($params, $rule,$fieids,$time)
    {
        return $this
            ->order($params['sort'], $params['order'])
            ->page($params['page'], $params['rows'])
            ->whereTime('task.task_time', $time)
            ->where($rule, $fieids)
            ->select();
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
        return $this
            ->order($params['sort'], $params['order'])
            ->page($params['page'], $params['rows'])
            ->where($rule, $fieids)
            //->fetchSql()
            ->select();
    }

    public function total()
    {
        return $this->count();
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
        return $this
            ->order($params['sort'], $params['order'])
            ->page($params['page'], $params['rows'])
            ->where($rule, $fieids)
            ->where('task.task_time', '<= time', $start)
            ->select();
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
        $exps = [
            "eq" => [],
            "like" => [],
            "in" => [],
            "between time" => [],
        ];
        //日期字段,对应html type 的 value
        $datekeys = [
            0 => 'add_time',
            1 => 'I_date',
            2 => 'II_date',
            3 => 'speed_time'
        ];
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
        return $this->where('order', 1)
            ->order($params['sort'], $params['order'])
            ->page($params['page'], $params['rows'])
            ->where($map)
            ->select();
    }

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

    /**
     * 外勤的任务是:去窗口一审;二审;拿调令;监督准备二审材料
     * @param $post
     * @param $task
     * @param $data
     */
    public function wsuccess($data, $post)
    {
        switch ($this->getData('type')) {

            /** 完成任务:窗口一审  **/
            case self::SIGN:

                //新建任务 回访一审 TO 内勤
                $envd = $this->_sysAddTask($this->clents_id, self::BACK_SIGN, $data->nuser_id, time());
                break;

            /** 完成任务:窗口二审  **/
            case self::SUBMIT:

                //新建惹怒 二审回访 TO 内勤
                $envd = $this->_sysAddTask($this->clents_id, self::BACK_SUBMIT, $data->nuser_id, time());
                break;

            /** 完成任务:拿调令  **/
            case self::GET_DIAOLING:

                //新建任务 调令回访 TO 业务员
                $envd = $this->_sysAddTask($this->clents_id, self::GET_DIAOLING, $data->user_id, time());
                break;

            /** 完成任务:二审材料  **/
            case self::SUBMIT_DATA:
                //根据分支完成情况 新建任务 TO 自己
                $post['js'] = isset($post['js']) ? true : false;
                $post['tj'] = isset($post['tj']) ? true : false;
                $post['gz'] = isset($post['gz']) ? true : false;
                if ($post['js'] == false || $post['tj'] == false || $post['gz'] == false) {
                    $envd = $this->_sysAddTask(
                        $this->clents_id,
                        self::SUBMIT_DATA, $data->wuser_id,
                        Time::daysAfter(8), $post
                    );
                }
                break;
        }
    }

    /**
     * 窗口一审;二审;拿调令处理失败tag标记失败
     * @param $data
     * @param $post
     */
    public function wFailed($data, $post)
    {
        switch ($this->getData('type')) {

            /** 未完成任务:窗口一审  **/
            case self::SIGN:
                //新建任务 回访一审 TO 内勤
                $envd = $this->_systemTask($task->clents_id, Task::BACK_SIGN, $re_by_id, time(),
                    ['success' => false], $post);
                break;

            /** 未完成任务:窗口二审  **/
            case self::SUBMIT:

                //新建惹怒 二审回访 TO 内勤
                $envd = $this->_systemTask($task->clents_id, Task::BACK_SUBMIT, $re_by_id, time(),
                    ['success' => false], $post);
                break;

            /** 未完成任务:拿调令  **/
            case self::GET_DIAOLING:

                //新建任务 调令回访 TO 业务员
                $envd = $this->_systemTask($task->clents_id, Task::GET_DIAOLING, $re_by_id, time(),
                    ['success' => false], $post);
                break;
        }
    }

    /**
     * 内勤的任务是:回访一审;回访二审
     * @param $post      success.html post 数据
     * @param $task      Task 实例
     * @param $data      Data 实例
     */
    public function nsuccess($data, $post)
    {
        switch ($this->getData('type')) {
            /** 完成任务:回访一审  **/
            case self::BACK_SIGN:
                //如果外勤完成时候不是失败的.

                if (!$this->Tag['success']) {

                    //提交到一审状态..
                    $data->sign();

                    //新建任务 约号 TO 管理员
                    $envd = $this->_sysAddTask($this->clents_id, self::APPOINTMENT, 1, Time::daysAfter(1));

                    //新建任务 二审材料 TO 外勤
                    $envd = $this->_sysAddTask($this->clents_id, self::SUBMIT_DATA, $data->wuser_id, Time::daysAfter(7));
                } else {

                    //外勤完成失败了 约号 TO 管理员
                    $envd = $this->_sysAddTask($this->clents_id, self::APPOINTMENT, 1, Time::daysAfter(3));
                }
                break;

            /** 完成任务:回访二审  **/
            case self::BACK_SUBMIT:
                if ($this->Tag['success'] != false) {

                    //二审成功 提交二审
                    $data->submit();
                } else {

                    //二审失败 新建任务 约号 TO 管理员
                    $envd = $this->_sysAddTask($this->clents_id, self::APPOINTMENT, 1, Time::daysAfter(3));
                }
                break;
        }
    }

    /**
     * 业务员的任务是:回访拿调令;准迁;落户
     * @param $post
     * @param $task_id
     * @param $data_id
     */
    public function ysuccess($data, $post)
    {
        switch ($this->getData('type')) {

            /** 完成任务:拿调令  **/
            case self::BACK_DIAOLIN:
                //提交为拿调令状态
                $data->takeDiaol($this->clents_id);
                //新建任务 打准迁 TO 自己
                $envd = $this->_sysAddTask($this->clents_id, self::CAN_MOVE, $data->user_id, Time::daysAfter(7));
                break;

            /** 完成任务:打准迁  **/
            case self::CAN_MOVE:
                //新建任务 落户 TO 自己
                $envd = $this->_sysAddTask($this->clents_id, self::SETTLE, $data->user_id, Time::daysAfter(7));
                break;

            /** 完成任务:落户  **/
            case self::SETTLE:
                break;
        }
    }

    private function _sysAddTask($clents_id, $type, $re_by_id, $time, $tag = null, $error_msg = null)
    {
        $data = [
            'clents_id' => $clents_id,
            'type' => $type,
            'se_by_id' => 10000,
            're_by_id' => $re_by_id,
            'task_time' => $time,
            'Tag' => $tag,
            'error' => $error_msg
        ];
        $newtask = new self();
        return $newtask->isUpdate(false)->save($data);
    }

    const SIGN = 1;//一审
    const SUBMIT = 2;//已二审
    const GET_DIAOLING = 3;//拿调令
    const BACK_SIGN = 5;//一审回访
    const BACK_SUBMIT = 6;//二审回访
    const BACK_DIAOLIN = 7;//拿调令回访
    const APPOINTMENT = 8; //约号
    const CAN_MOVE = 9; //准迁
    const SETTLE = 10;//落户
    const SUBMIT_DATA = 11;

    /******************************************************************************************************************/
    public function getTitleAttr($key, $d)
    {
        $data = [
            1 => '签协议',
            2 => '提交材料',
            3 => '拿调令',
            4 => '其他',
            5 => '一审回访',
            6 => '二审回访',
            7 => '拿调令回访',
            8 => '约号',
            9 => '打准迁',
            10 => '办落户',
            11 => '备二审材料',
            12 => '出号约客户'
        ];
        return isset($data[$d['type']]) ? $data[$d['type']] : '';
    }

    public function getFinishTypeAttr($key)
    {
        $data = [
            1 => '进行中',
            2 => '完成',
            3 => '转发',
            0 => '失败',
        ];
        return isset($data[$key]) ? $data[$key] : "";
    }

}