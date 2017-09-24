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
class Index extends Controller
{
    public function index()
    {
        return $this->fetch('main');
    }

    public function login()
    {
        return $this->fetch('login/index');
    }
    public function settings(){
         return response($this->fetch("/index/TabsJson/settings"));
    }
}