<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/28
 * Time: 22:39
 */

namespace app\api\validate;
use think\Validate;

class Data extends Validate
{
    protected $rule =   [
        'name'  => 'require|max:25',
        'card'  => 'require|idCard|unique:data',// 表示验证card字段的值是否在data表（不包含前缀）中唯一
    ];
    protected $message  =   [
        'name.require' => '姓名必须填写',
        'name.max'     => '名称最多不能超过25个字符',
        'card.unique'  => '已存在的身份证',
    ];
    protected $scene = [
        'edit'  =>  ['name','tel'],
    ];
}