<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/22
 * Time: 20:42
 */

namespace app\ui\controller;
use think\Controller;

class Task extends  Controller
{
    function index(){
       return response($this->fetch());
    }
}