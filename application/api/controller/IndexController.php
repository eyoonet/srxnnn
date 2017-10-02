<?php
namespace app\api\controller;
use app\api\model\Data;
use app\api\model\Log;
use app\api\model\User;
use app\common\controller\Base;
use app\common\org\Res;
use think\Collection;
use think\Controller;
use think\Db;

class IndexController extends Collection
{
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
                }else{
                    //return "=";
                }
            }
        }
    }

    //测试专用
    public function index()
    {
        //表达式定义
        $exps = [
            "eq"      => [],
            "like"    => ['name','tel','rdate'],
            "in"      => ['222'],
            "between" => ['add_time','I_date','II_date','speed_time']
        ];
        $date[] = '2017-10-01';
        $date[] = '2017-10-31';
        $u = new User();
        $array = array(
            'name' => 'apple',
            'date_type' => 1,
            'date'   =>  ['2017-10-01','2017-10-30'],
            'fruit3' => 'grape',
            'fruit4' => 'apple',
            'fruit5' => 'apple');
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
        while ($value = current($array)) {
            $key   =  key($array);
            $exp   =  $this->exp($exps,$key);
            if($exp == null )$exp = "=";
            $map[] = [ $key, $exp , $value ];
            next($array);
        }

        dump($u->where($map)->where('status',1)->fetchSql(true)->select());

        //dump($u->info(1));
        //$a= new Log();
        //dump($a->getSysActionLog());
        //dump($a->getUserActionLog());
    }
}
