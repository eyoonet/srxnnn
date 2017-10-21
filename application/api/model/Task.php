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
            ->view('task', 'id,type,title,comments,create_time,task_time,finish_time,finish_type,clents_id')
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
            ->view('task', 'id,type,title,comments,create_time,task_time,finish_time,finish_type,clents_id')
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
            ->view('task', 'id,type,title,comments,create_time,task_time,finish_time,finish_type,clents_id')
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


    /******************************************************************************************************************/
    public function getTypeAttr($key)
    {
        $data = [
            0 => '其他',
            1 => '一审',
            2 => '二审',
            3 => '拿调令',
            4 => '计生',
            5 => '体检'
        ];
        return isset($data[$key]) ? $data[$key] : '';
    }

    public function getFinishTypeAttr($key)
    {
        $data = [
            1 => '进行中',
            2 => '完成',
            0 => '失败',
        ];
        return isset($data[$key]) ? $data[$key] : "";
    }

}