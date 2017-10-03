<?php
namespace app\api\controller;

use app\api\model\User;
use think\Controller;
use think\Session;
use app\common\org\Res;

class UserController extends Controller
{

    public function doLogin(User $user)
    {
        $username = $this->request->param('user');
        $password = $this->request->param('password');
        $uid = $user->login($username, $password);
        if ($uid) {
            session('uid', $uid);
            return Res::Json(100);
        } else {
            session('uid', null);
            return Res::Json(-100,$user->error);
        }
    }
    public function logout(){
        session('uid', null);
        $this->redirect('/');
    }
    public function doRegister(User $user)
    {
        $data   = $this->request->param();
        $result = $user->register($data);
        if ($result) {
            $this->success('用户注册成功');
        } else {
            $this->error($user->getError());
        }
    }

    public function getUserInfo(User $user, $uid)
    {
        $info = $user->info($uid);
        if ($info) {
            $this->assign('user', $info);
            return $this->fetch();
        } else {
            return '用户不存在';
        }
    }

    protected function getUserRole()
    {
        $uid  = Session::get('user_id');
        $user = User::get($uid);
        return $user->role();
    }
}