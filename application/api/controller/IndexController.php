<?php
namespace app\api\controller;
use app\api\model\Log;
use app\api\model\User;
use app\common\controller\Base;
use think\Collection;
use think\Controller;
use think\Db;

class IndexController extends Collection
{
    //测试专用
    public function index()
    {
  

       return json($a);
       // $u = new User();


        //dump($u->info(1));


        //$a= new Log();
        //dump($a->getSysActionLog());
        //dump($a->getUserActionLog());
    }
}
