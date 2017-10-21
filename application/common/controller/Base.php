<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/27
 * Time: 16:20
 */

namespace app\common\controller;
use app\api\model\Log;
use app\api\model\User;
use think\Controller;


class Base extends Controller
{
    protected $uid;
    protected $tokgen;
    protected $url;
    protected $auth;
    protected $group_id;
    /**
     *  控制器初始化用户权限认证一下
     */
    public function initialize(){
        $this->uid      = session('uid');
        $this->tokgen   = $this->request->param('TokGen');
        if( $this->uid == null) {
            if($this->tokgen == null ){
                $this->redirect("ui/login/index");
            } else{
                $tid = User::checkToken($this->tokgen);
                if($tid){
                    session('uid',$tid);
                    $this->uid      = $tid;
                }else{
                    $this->redirect("ui/login/index");
                }
            }
        }
        $this->group_id = User::getUserGroupId($this->uid);
        $this->auth();
        //$this->log();
    }
    private function auth(){
        $module     = $this->request->module();
        $controller = $this->request->controller();
        $action     = $this->request->action();
        $this->url  = "{$module}/{$controller}/{$action}"; //$this->request->routeInfo()['route'];
        $auth       = new Auth();
        $this->auth = $auth->check( $this->url , $this->uid );
    }

    protected function log(){
        $log  = new Log();
        $data = [
            'group_id'  => $this->group_id,
            'rule_url'  => $this->url,
            'user_id'   => $this->uid,
            'action_ip' => $this->request->ip()
        ];
        $log->save($data);
    }

}