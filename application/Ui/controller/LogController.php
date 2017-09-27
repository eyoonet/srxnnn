<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/23
 * Time: 19:28
 */

namespace app\ui\controller;
use think\Controller;

class LogController extends Controller
{
    function index(){
        return response($this->fetch("/index/TabsJson/log"));
    }
}