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
        'task_time'  => 'timestamp',
        'finish_time'=> 'timestamp',
    ];
    public function TList($rule,$fieids){
       return  $this
           //->where($rule,$fieids)
           ->view('task','title,comments,create_time,task_time,finish_time')
           ->view('user','user_name as re_name','task.re_by_id = user.id')
           ->view('user','user_name as se_name','task.se_by_id=user.id')
           ->select();
    }
    public function total(){
       return  $this->count();
    }

    public function getTypeAttr($key)
    {
        $data = [
            1 =>'客户任务',
            2 =>'其他'
        ];
        return isset($data[$key]) ? $data[$key] : "";
    }
    public function getFinishTypeAttr($key)
    {
        $data = [
            1 =>'为办',
            2 =>'完成',
            0 =>'失败',
        ];
        return isset($data[$key]) ? $data[$key] : "";
    }

}