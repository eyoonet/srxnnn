<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/27
 * Time: 16:20
 */

namespace app\common\controller;
use think\Controller;


class Base extends Controller
{
    protected $uid;
    public function initialize(){
        $this->uid = session('uid');
        if( $this->uid == null) {
            $this->redirect("ui/login/index");
        }
    }
}