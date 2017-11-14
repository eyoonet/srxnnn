<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/12
 * Time: 19:04
 */

namespace app\api\validate;


use think\Validate;

class Task extends Validate
{
    protected $rule =   [
        'template_id'  => 'require',
        're_id'  => 'require',
        'contnet'=>'require',
        'reply_text'=>'require',
        'task_time'=>'dateFormat:Y-m-d H:i'
    ];
    protected $message  =   [
        'template_id.require' => '任务类型不能为空',
        're_id.require'     => '接收者ID不能为空',
        'contnet.require'     => '任务描述不能为空',
        'reply_text.require'     => '回复内容不能为空',
        'task_time'            =>'执行日期填写出错',
    ];
    protected $scene = [
        'dispose'  =>  ['reply_text'],
        'add'  =>  ['template_id','re_id','content','task_time'],
    ];
}