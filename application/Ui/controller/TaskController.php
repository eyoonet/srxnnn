<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/22
 * Time: 20:42
 */

namespace app\ui\controller;
use think\Controller;

class TaskController extends  Controller
{
    function index(){
       return response($this->fetch('/index/TabsJson/task'));
    }
}