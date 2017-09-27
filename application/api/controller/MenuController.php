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
use app\common\org\Res;

class MenuController extends Controller
{
    /**
     *  取所有所有菜单用于菜单管理列表
     * @param MenuTree $sidebar
     * @return mixed
     */
    public function getSidebarAll(MenuTree $sidebar)
    {
        return json($sidebar->getMenuall());
    }

    /**
     *  取菜单列表按系统
     * @param MenuTree $sidebar
     * @param string $tag  标记
     * @return mixed
     */
    public function getSidebar(MenuTree $sidebar, $tag)
    {
        return json($sidebar->getMenu(1, $tag));
    }

    /**
     *  菜单排序
     * @param $id
     * @param $value
     * @return mixed
     */
    public function setSort($id,$value)
    {
        return MenuTree::setSort($id,$value);
    }

    /**
     *  菜单添加
     * @param MenuTree $sidebar
     * @return mixed
     */
    public function create( MenuTree $sidebar)
    {
        if( $sidebar->save( $this->request->post() ) ){
            return Res::Json(200);
        }
    }

    /**
     *  菜单删除
     * @param $id
     * @return mixed
     */
    public function delete($id){
        $data = MenuTree::destroy($id);
        if($data){
            return Res::Json(200);
        }else{
            return Res::Json(400);
        }
    }

    /**
     *  编辑一条菜单信息
     * @param $id
     * @return \think\response\Json
     */
    public function edit($id){
        $data = $this->request->post();
        $sqldata = MenuTree::get($id)->data($data)->save();
        if($sqldata){
            return res();
        }else{
            return Res::Json(200);
        }
    }
}