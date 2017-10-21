<?php
namespace app\api\controller;
use app\api\model\Data;
use app\api\model\Log;
use app\api\model\Task;
use app\api\model\User;
use app\common\controller\Base;
use app\common\org\Res;
use think\Collection;
use think\Controller;
use think\Db;
use think\helper\Time;
class IndexController extends Collection
{
    //测试专用
    public function index()
    {
        list($start, $end) = Time::today();// 今日开始和结束的时间戳
        dump( $start);


        $M = new Task();


      dump($M->where('create_time', '> time', '2016-1-1')->fetchSql(true)->select());

       /* $m = new Data();

        $array = ['name'=>'333','shebao'=>'2323'];
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
        return $m->where('order',null)
            ->order('add_time','desc')
            ->fetchSql(true)
            ->where($map)->select();*/



       /*list($start, $end) = Time::today();
        echo $start; // 零点时间戳
        echo $end; // 23点59分59秒的时间戳
       dump(  Time::today());*/

        //$m = new Data();

        //dump($m->get(1));
        //dump($u->info(1));
        //$a= new Log();
        //dump($a->getSysActionLog());
        //dump($a->getUserActionLog());
    }
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
}
