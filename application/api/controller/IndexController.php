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
use think\helper\Time;
class IndexController extends Collection
{
    //测试专用
    public function index()
    {

      $m = new Data();
        $data=[
            'card' => '420682199011051025',
            'name' => 'sdafasdf'
        ];
        $m->save($data,['id'=>44]);

        dump( $m->DataImg());



/*        list($start, $end) = Time::today();
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
}
