<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/26
 * Time: 13:43
 */

namespace app\api\model;


use think\Model;

class AuthUserHtml extends Model
{
    public static function getByHtmls($group_id,$key)
    {
        return self::where('key', $key)
            ->field('html')
            ->where('group_id', 'in', [$group_id, 0])
            ->select();
    }
}