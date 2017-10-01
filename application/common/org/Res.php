<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/27
 * Time: 11:19
 */
namespace app\common\org;
class Res
{
    protected  $url  = null;
    protected  $msg  = null;
    protected  $code = 200 ;
    protected  $data = array();
    public static function Json($code, $msg = null, $data = array())
    {
        $msgs = [200 => '提交成功!', 400 => '提交失败!', 100 => '登陆成功!',300=>'跳转'];
        if ($msg == null) {
            return json(['code' => $code, 'msg' => $msgs[$code], 'data' => $data]);
        }else{
            return json(['code' => $code, 'msg' => $msg, 'data' => $data]);
        }
    }
    public function toJson(){
        return json([
            'code' => $this->code,
            'msg'  => $this->msg,
            'data' => $this->data,
            'url'  => $this->url
        ]);
    }
    public function data($data){

    }
    public function setMsg($msg){
        $this->msg = $msg;
        return $this;
    }

    public function setCode($code){
        $this->code = $code;
        return $this;
    }

    public function setUrl($url){
        $this->url = $url;
        return $this;
    }
}