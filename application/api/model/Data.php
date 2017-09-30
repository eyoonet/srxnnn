<?php
namespace app\api\model;
use think\model;
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/24
 * Time: 13:48
 */
class Data extends Model
{
    protected $autoWriteTimestamp = true;
    protected $createTime = 'add_time';
    public function dgList(){
         $this->where('order',1)->all();
    }





    /**
     * 获取器
     */
    //  `marriage` tinyint(1) unsigned DEFAULT NULL COMMENT '01未婚 02已婚 03离异 04丧偶',
    public function getMarriageAttr($key)
    {
        $data = ['01' => '未婚', '02' => '已婚', '03' => '离异', '04' => '丧偶'];
        return $data[$key];
    }
    //`education` tinyint(1) unsigned DEFAULT NULL COMMENT '学历:1博士.2硕士.3本科.4大专',
    public function getEducationAttr($key)
    {
        $data = ['01'=>'博士','02'=>'硕士','03'=>'本科','04'=>'大专'];
        return $data[$key];
    }
    //`order` tinyint(2) DEFAULT NULL COMMENT '订单 1 正常 -1 退款',
    public function getOrderAttr($key)
    {
        $data = [1=>'正常',-1=>'退款'];
        return $data[$key];
    }
    //`mode` varchar(10) DEFAULT NULL COMMENT '模式:核准积分12.应届生3.留学生5',
    public function getModeAttr($key)
    {
        $data = ['03'=>'应届生','05'=>'留学生','12'=>'核准制'];
        return $data[$key];
    }
    //  `sbtype` tinyint(1) unsigned DEFAULT '1' COMMENT '申报类型(1.个人2.单位)',
    public function getSbtypeAttr($key)
    {
        $data = [1 => '个人申报', 2 => '单位申报'];
        return $data[$key];
    }
    //`zdtype` tinyint(1) DEFAULT '1' COMMENT '招调类型(1.招工2.调干)',
    public function getZdtypeAttr($key)
    {
        $data = ['01' => '招工', '02'=>'调干' ];
        return $data[$key];
    }
    //`dangan` tinyint(2) DEFAULT '-1' COMMENT '调档 -1 | 1',
    public function getDanganAttr($key)
    {
        $data = [-1 => '否' , 1=>'是' ];
        return $data[$key];
    }
    // `speed` tinyint(1) DEFAULT '0' COMMENT '进度 0 未办 1 一审 2 二审 3 完结',
    public function getSpeedAttr($key)
    {
        $data = [ 0 => '未办' ,1 => '签协议' , 2 =>'交材料', 3 =>'完结'];
        return $data[$key];
    }
}