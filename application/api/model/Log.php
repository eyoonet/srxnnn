<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/28
 * Time: 14:19
 */

namespace app\api\model;

use think\Model;

class Log extends Model
{
    protected $autoWriteTimestamp = true;

    public function getUserActionLog($page,$rows)
    {
        $sqldata = $this->view('Log', 'id,rule_url,type,create_time,action_ip')
            ->view('User', 'user_name', 'user.id = log.user_id ','LEFT')
            ->view('auth_group', 'title', 'auth_group.id = log.group_id','LEFT')
            ->view('auth_rule', 'title as action', 'auth_rule.name = log.rule_url','LEFT')
            ->view('Data', 'name as uname', 'data.id = log.clents_id','LEFT')
            ->order('create_time desc')
            ->page($page,$rows)
            ->select();
        return $sqldata;
    }

    public function getSysActionLog($page,$rows)
    {
        $sqldata = $this->view('Log', 'id,rule_url,type,create_time,action_ip')
            ->view('User', 'user_name', 'user.id = log.user_id ','LEFT')
            ->view('auth_group', 'title', 'auth_group.id = log.group_id','LEFT')
            ->view('auth_rule', 'title as action', 'auth_rule.name = log.rule_url','LEFT')
            ->order('create_time desc')
            ->page($page,$rows)
            ->select();
        return $sqldata;
    }

    public function getTypeAttr($key)
    {
        $type = [1 => "系统", 2 => "用户", 3 => "其他"];
        return $type[$key];
    }

}