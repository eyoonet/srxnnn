<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/27
 * Time: 18:24
 */

namespace app\ui\controller;

use think\Controller;

class LoginController extends Controller
{
    public function index()
    {
        if ($this->request->isMobile()) {
            return $this->fetch('login/Mobile');
        } else {
            return $this->fetch('login/PC');
        }
    }
}