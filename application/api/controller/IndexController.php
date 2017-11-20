<?php
namespace app\api\controller;
use app\api\model\Data;
use app\api\model\Log;
use app\api\model\Task;
use app\api\model\User;
use app\common\controller\Base;
use app\common\lib\Curl;
use app\common\lib\LibFile;
use app\common\org\Res;
use think\Collection;
use think\Controller;
use think\Db;
use think\helper\Time;
class IndexController extends Controller
{

   public function test($a,$b){
       echo "123".$a.$b;
   }

    //测试专用
    public function index()
    {
        $task = new Task();
        echo $task->getTotals();
        return $this->fetch();
    }

}
