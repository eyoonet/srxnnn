<?php
namespace app\ui\controller;
use think\Controller;
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/18
 * Time: 0:34
 */

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
}