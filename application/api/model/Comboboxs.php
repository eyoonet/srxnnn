<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/28
 * Time: 21:12
 */

namespace app\api\model;


use think\Model;

class Comboboxs extends Model
{
    public function getCombobox( $Tag ){
        return $this->where('tag',$Tag)->select();
    }
}