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
    protected $url;
    public static function Json($code, $msg = null, $data = array())
    {
        $msgs = [200 => '提交成功!', 400 => '提交失败!', 100 => '登陆成功!',300=>'跳转'];
        if ($msg == null) {
            return json(['code' => $code, 'msg' => $msgs[$code], 'data' => $data]);
        }else{
            return json(['code' => $code, 'msg' => $msg, 'data' => $data]);
        }
    }
}