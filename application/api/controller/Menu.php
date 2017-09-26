<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/24
 * Time: 14:17
 */

namespace app\api\controller;

use app\api\model\MenuTree;
use think\Controller;

class Menu extends Controller
{
    public function getSidebarAll(MenuTree $sidebar)
    {
        return json($sidebar->getMenuall());
    }
    public function getSidebar(MenuTree $sidebar, $tag)
    {
        return json($sidebar->getMenu(1, $tag));
    }

    public function setSort($id,$value)
    {
        return MenuTree::setSort($id,$value);
    }
    public function create( MenuTree $sidebar)
    {
        if( $sidebar->save( $this->request->post() ) ){
            return json(['code'=>200,'msg'=>"添加成功"]);
        }
    }
    public function delete($id , MenuTree $sidebar ){
        $data = MenuTree::destroy($id);
        if($data){
            return json(['code'=>200,'msg'=>"操作成功",'data'=>$data]);
        }else{
            return json(['code'=>300,'msg'=>"出错啦!",'data'=>$data]);
        }
    }
}