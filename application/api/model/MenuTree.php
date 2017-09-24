<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/24
 * Time: 13:51
 */

namespace app\api\model;


use think\Model;

class MenuTree extends Model
{
    /**
     * 取菜单
     * @param $groupId
     * @param $tag
     * @return array
     */
    public function getMenu($groupId = null, $tag = null)
    {
        $arr = $this->where('group_id', $groupId)
            ->where('status', 1)
            ->where('tag', $tag)
            ->order('sort desc')
            // ->fetchSql(true)
            ->select();
        return $this->formatSidebar($arr);
    }

    /**
     *  取所有菜单
     * @return array
     */
    public  function getMenuAll()
    {
        $arr = $this->select();
        return $this->formatSidebar($arr);
    }

    public static function  setSort($id,$value)
    {
       return self::get($id)->data('sort',$value)->save();
    }


    /**
     * 返回json 数据格式菜单
     * @param $array
     * @param int $fid
     * @return array
     */
    private function formatSidebar($array, $fid = 0)
    {
        $arr = array();
        $tem = array();
        foreach ($array as $v) {
            if ($v['fid'] == $fid) {
                $tem = $this->formatSidebar($array, $v['id']);
                //判断是否存在子数组
                $tem && $v['children'] = $tem;
                $arr[] = $v;
            }
        }
        return $arr;
    }
}