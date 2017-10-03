<?php
namespace app\api\model;
use think\Model;

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

    /*public function initialize()
    {
        parent::initialize(); // TODO: Change the autogenerated stub
        self::event('before_update', function  ($data)  {
            dump($data->toArray());
            $data->DataImg()->save($data->toArray());
        });
    }
    public function DataImg()
    {
        return $this->hasOne('DataImg');
    }*/
    public function bak($type){
        $id = $this->getData('id');
        if($id){
            $m                 = new DataImg();
            $data              = $this->toArray();
            $data['data_id']   = $id;
            $data['edit_type'] = $type;
            unset($data['id']);
            if($m->save($data )){
                return true;
            } else{
                return false;
            }
        }else{
            $this->error = '未返回模型实例';
            return false;
        }
    }
    /**
     * 菜单获取表格格式数据
     * 'id > :id AND name LIKE :name ', ['id' => 0, 'name' => 'thinkphp%']
     * @param $page integer 分页
     * @param $rows integer 分页
     * @param $rule string 规则
     * @param $data array 数据
     * @return array|\PDOStatement|string|\think\Collection
     */
    public function getDgList($page,$rows,$rule,$fieids){
        return $this->where('order',null)
             ->order('add_time', 'desc')
             ->page($page,$rows)
             ->where($rule,$fieids)
             //->fetchSql(true)
             ->select();
    }
    public function total(){
        return $this->where('order',null)->count();
    }

    public function back($id){
        $data = $this->get($id);

    }

    /**
     * 数据删除不是真的删除只是改了一下标记
     * @param $id
     * @return false|int
     */
    public function dataDel($id){
        return $this->save(['order'=>0 ],['id'=>$id]);
    }

    /**
     * 搜索数据
     * @post @date_type int
     * @powt @date array
     * @param $page
     * @param $rows
     * @param $array
     * @return array|\PDOStatement|string|\think\Collection
     */
    public function search($page,$rows,$array){
        //表达式定义
        $exps = [
            "eq"      => [],
            "like"    => ['name','tel','rdate'],
            "in"      => ['mode','speed','sbtype','service','status'],
            "between time" => ['add_time','I_date','II_date','speed_time']
        ];
        //日期字段,对应html type 的 value
        $datekeys = [
            0 => 'add_time',
            1 => 'I_date',
            2 => 'II_date',
            3 => 'speed_time'
        ];

        if( isset($array['date_type']) ){
            $type           = $array['date_type'];// 等于数字
            $datepk         = $datekeys[$type];
            $array[$datepk] = $array['date'];
            unset($array['date_type']);unset($array['date']);
        }

        //map条件组装.
        $map = array();
        while ($value = current($array)) {
            $key   =  key($array);
            $exp   =  $this->exp($exps,$key);
            if($exp == null )$exp = "=";
            $map[] = [ $key, $exp ,$value];
            next($array);
        }
        return $this->where('order',null)
            ->order('add_time','desc')
            ->page($page,$rows)
            //->fetchSql(true)
            ->where($map)->select();
    }

    /**
     * 就是返回数组格式为 不知道相同值会不会有问题
     * [
     *   "eq"      => ['name','tel'],
     *   "like"    => ['111'],
     *   "in"      => ['222'],
     *   "between" => ['333']
     * ]
     * @param $exps
     * @param $key
     * @return mixed
     */
    private function exp($exps,$key){
        foreach($exps as $expp){
            $expskey = array_search($expp,$exps);//获取value 为 $expp 的 key
            foreach($expp as $val ){
                if($key == $val){
                    return $expskey;
                }
            }
        }
    }

    /***********************************************************************************
     * **********************************修改器******************************************
     ***********************************************************************************/



    /***********************************************************************************
     ************************************获取器******************************************
     ***********************************************************************************/
    public function getStatusAttr($key){
        $data = [
            0 => '新进客户', 1 => '没有社保', 2 => '问题打回',  3=> '待录人保',
            4 => '提交人保', 5 => '已约号I',   6 => '已约号II',   7=> '已出号',
            8 =>'已一审',    9 => '可以二审', 10=> '已二审',   11=> '撤销终止',
            12=> '不予受理', 13=> '待报道',   14=> '审批中',   15=> '审批同意',
            16=> '出调令',   17=> '已拿调令', 18=> '完结',
        ];
        return isset($data[$key]) ? $data[$key] : '';
    }
    //  `marriage` tinyint(1) unsigned DEFAULT NULL COMMENT '01未婚 02已婚 03离异 04丧偶',
    public function getMarriageAttr($key)
    {
        $data = ['01' => '未婚', '02' => '已婚', '03' => '离异', '04' => '丧偶'];
        if( isset($data[$key]) ){
            return $data[$key];
        }
    }
    //`education` tinyint(1) unsigned DEFAULT NULL COMMENT '学历:1博士.2硕士.3本科.4大专',
    public function getEducationAttr($key)
    {
        $data = ['01'=>'博士','02'=>'硕士','03'=>'本科','04'=>'大专'];
        if( isset($data[$key]) ){
            return $data[$key];
        }
    }
    //`order` tinyint(2) DEFAULT NULL COMMENT '订单 1 正常 -1 退款',
    public function getOrderAttr($key)
    {
        $data = [1=>'正常',-1=>'退款'];
        if( isset($data[$key]) ){
            return $data[$key];
        }
    }
    //`mode` varchar(10) DEFAULT NULL COMMENT '模式:核准积分12.应届生3.留学生5',
    public function getModeAttr($key)
    {
        $data = ['03'=>'应届生','05'=>'留学生','12'=>'核准制'];
        if( isset($data[$key]) ){
            return $data[$key];
        }
    }
    //  `sbtype` tinyint(1) unsigned DEFAULT '1' COMMENT '申报类型(1.个人2.单位)',
    public function getSbtypeAttr($key)
    {
        $data = [1 => '个人申报', 2 => '单位申报'];
        if( isset($data[$key]) ){
            return $data[$key];
        }
    }
    //`zdtype` tinyint(1) DEFAULT '1' COMMENT '招调类型(1.招工2.调干)',
    public function getZdtypeAttr($key)
    {
        $data = ['01' => '招工', '02'=>'调干' ];
        if( isset($data[$key]) ){
            return $data[$key];
        }
    }
    //`dangan` tinyint(2) DEFAULT '-1' COMMENT '调档 -1 | 1',
    public function getDanganAttr($key)
    {
        $data = [0 => '否' , 1=>'是' ];
        if( isset($data[$key]) ){
            return $data[$key];
        }
    }
    // `speed` tinyint(1) DEFAULT '0' COMMENT '进度 0 未办 1 一审 2 二审 3 完结',
    public function getSpeedAttr($key)
    {
        $data = [ 0 => '未办' ,1 => '签协议' , 2 =>'交材料', 3 =>'完结'];
        if( isset($data[$key]) ){
            return $data[$key];
        }
    }
}