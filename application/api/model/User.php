<?php
namespace app\api\model;

use think\Model;

class User extends Model
{
    /**
     * 注册一个新用户
     * @param  array $data 用户注册信息
     * @return integer|bool  注册成功返回主键，注册失败-返回false
     */
    public function register($data = [])
    {
        $result = $this->validate(true)->allowField(true)->save($data);
        if ($result) {
            return $this->getData('id');
        } else {
            return false;
        }
    }

    /**
     * 用户登录认证
     * @param  string  $username 用户名
     * @param  string  $password 用户密码
     * @return integer 登录成功-用户ID，登录失败-返回0或-1
     */
    public function login($username, $password)
    {
        $where['user'] = $username;
        $where['status']   = 1;
        /* 获取用户数据 */
        $user = $this->where($where)->find();
        if ($user) {
            if (md5($password) != $user->password) {
                $this->error = '密码错误';
                return false;
            } else {
                $user->token = md5($username."99042837".$password);
                $user->client_ip = request()->ip();
                $user->login_time = time();
                $user->save();
                return $user->id;
            }
        } else {
            $this->error = '用户不存在或被禁用';
            return false;
        }
    }

    /**
     *  获取 tokgen
     * @param $uid
     * @return bool|mixed
     */
    public function getToken($uid){
        $user = $this->where('id',$uid)->field('token')->find();
        if ($user){
            return $user->token;
        }else{
            $this->error = '用户不存在或被禁用';
            return false;
        }
    }

    /**
     *  Token 效验证
     * @param $Token
     * @return bool
     */
    public static function checkToken($Token){
        $user = self::where('token',$Token)->find();
        if($user){
            return $user->id;
        }else{
            return false;
        }
    }
    /**
     * 获取用户信息
     * @param  integer  $uid 用户主键
     * @return array|integer 成功返回数组，失败-返回-1
     */
    public function info($uid)
    {
        $user = $this->where('id', $uid)->field('user_name,client_ip,login_time')->find();
        if ($user) {
            // 返回用户数据
            $auth_group = $this->table('auth_group')->where('id',$this->getUserGroupId($uid))->field('id,title')->find();
            if(!$auth_group){
                $this->error = '用户未授权';
                return false;
            }
            $user['group'] = $auth_group;
            return $user;
        } else {
            $this->error = '用户不存在';
            return false;
        }
    }

    public function comboboxUserList(){
      return  $this->field('id as value,user_name as text')->select();
    }
    /**
     * 获取用户角色
     * @return integer 返回角色信息或者返回-1
     */
    public function role()
    {
        $uid = $this->getData('id');
        if ($uid) {
            $role = $this->getUserGroupId($uid);
            if ($role) {
                return $role;
            } else {
                $this->error = '用户未授权';
                return 0;
            }
        } else {
            $this->error = '请先登录';
            return -1;
        }
    }

    public static function getUserGroupId($uid)
    {
        $sqldata =  self::table('auth_group_access')->where('uid', $uid)->find();
        if( $sqldata ){
            return $sqldata->group_id;
        }
    }
}