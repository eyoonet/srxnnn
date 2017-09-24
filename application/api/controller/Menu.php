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
        return json($sidebar->getMenu(null, $tag));
    }

    public function setSort($id,$value)
    {
        return MenuTree::setSort($id,$value);
    }
}