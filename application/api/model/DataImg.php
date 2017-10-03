<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/3
 * Time: 12:15
 */

namespace app\api\model;


use think\Model;

class DataImg extends Model
{
    protected $autoWriteTimestamp = true;


    public function getEditTypeAttr($key)
    {
        $data = [
            0=>'编辑',
            1=>'一审',
            2=>'二审',
            3=>'完结'
        ];
        return isset($data[$key]) ? $data[$key] : '' ;
    }
}