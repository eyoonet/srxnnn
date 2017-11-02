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
            ->view('task', 'id,type,title,comments,create_time,task_time,finish_time,finish_type,clents_id,error,Tag')
            ->view('user A', 'user_name as se_name', 'task.se_by_id = A.id', 'LEFT')
            ->view('user B', 'user_name as re_name', 'task.re_by_id = B.id', 'LEFT')
            ->view('data', 'name as clents_name', 'task.clents_id=data.id', 'LEFT')
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
            ->view('task', 'id,type,title,comments,create_time,task_time,finish_time,finish_type,clents_id,error,Tag')
            ->view('user A', 'user_name as se_name', 'task.se_by_id = A.id', 'LEFT')
            ->view('user B', 'user_name as re_name', 'task.re_by_id = B.id', 'LEFT')
            ->view('data', 'name as clents_name', 'task.clents_id=data.id', 'LEFT')
            //->fetchSql()
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
    public function search($params, $array, $group_id)
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
            ->view('task', 'id,type,title,comments,create_time,task_time,finish_time,finish_type,clents_id,error,Tag')
            ->view('user A', 'user_name as se_name', 'task.se_by_id = A.id', 'LEFT')
            ->view('user B', 'user_name as re_name', 'task.re_by_id = B.id', 'LEFT')
            ->view('data', 'name as clents_name', 'task.clents_id=data.id', 'LEFT')
            //->fetchSql(true)
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