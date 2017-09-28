<?php
namespace app\api\controller;
use app\api\model\Log;
use app\api\model\User;
use app\common\controller\Base;
use think\Controller;
use think\Db;

class IndexController extends Base
{
    //测试专用
    public function index()
    {

      dump($this->request);
      exit;
       // $u = new User();


        //dump($u->info(1));


        $a= new Log();
        dump($a->getSysActionLog());
        //dump($a->getUserActionLog());
    }
}
