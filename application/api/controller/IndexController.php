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
    //测试专用
    public function index()
    {

        $a = new Data();


       // $u = new User();


        //dump($u->info(1));


        //$a= new Log();
        //dump($a->getSysActionLog());
        //dump($a->getUserActionLog());
    }
}
