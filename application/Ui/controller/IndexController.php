<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/18
 * Time: 0:34
 */
namespace app\ui\controller;

use think\Controller;
use app\api\model\MenuTree;
use app\common\controller\Base;
use app\api\model\User;

class IndexController extends Base
{
    public function index()
    {
        $user = new User();
        $this->assign('token',$user->getToken($this->uid));
        return $this->fetch('/PC/main');
    }
    public function Settings()
    {
        return response($this->fetch("/PC/TabsJson/settings"));
    }
    public function Log(){
        return response($this->fetch("/PC/TabsJson/log"));
    }
    public function Task(){
        return response($this->fetch('/PC/TabsJson/task'));
    }

    public function Mobile(){
        return response($this->fetch('/Mobile/main'));
        //return response($this->fetch('/Mobile/pages/tabs/dg'));
    }
}