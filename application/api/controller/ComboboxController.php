<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/28
 * Time: 21:25
 */

namespace app\api\controller;
use app\api\model\Comboboxs;
use app\api\model\MenuTree;
use app\api\model\User;
use app\common\controller\Base;
class ComboboxController extends Base
{
    public function get(Comboboxs $combox , $tag){
        $where = [
          'tag' =>   $tag
        ];
        return $combox->order('sort asc')->where($where)->select();
    }
    public function userlist(User $user){
       return  $user->comboboxUserList();
    }
    public function menufidlist(MenuTree $menu){
        return $menu->getfidlist();
    }
}