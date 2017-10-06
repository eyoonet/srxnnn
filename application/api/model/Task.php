<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/6
 * Time: 0:55
 */

namespace app\api\model;
use think\Model;

class Task extends Model
{
    protected $autoWriteTimestamp = true;
    protected $type =[
        'task_time'  => 'timestamp:Y-m-d H:i',
        'finish_time'=> 'timestamp:Y-m-d H:i',
    ];
    public function TList($params,$rule,$fieids){
       return  $this
           ->order($params['sort'], $params['order'])
           ->page( $params['page'], $params['rows'])
           ->where($rule,$fieids)
           ->view('task','id,type,title,comments,create_time,task_time,finish_time,finish_type,clents_id')
           ->view('user A','user_name as se_name','task.se_by_id = A.id','LEFT')
           ->view('user B','user_name as re_name','task.re_by_id = B.id','LEFT')
           ->view('data','name as clents_name','task.clents_id=data.id','LEFT')
           //->fetchSql()
           ->select();
    }
    public function total(){
       return  $this->count();
    }

    public function getTypeAttr($key)
    {
        $data = [
            0 =>'其他',
            1 =>'一审',
            2 =>'二审',
            3 =>'拿调令',
            4 =>'计生',
            5 =>'体检'
        ];
        return isset($data[$key]) ? $data[$key]: '';
    }

    public function getFinishTypeAttr($key)
    {
        $data = [
            1 =>'进行中',
            2 =>'完成',
            0 =>'失败',
        ];
        return isset($data[$key]) ? $data[$key] : "";
    }

}