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
        return $this->fetch('main');
    }


    public function settings()
    {
        return response($this->fetch("/index/TabsJson/settings"));
    }
}