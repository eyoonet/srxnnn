<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/28
 * Time: 23:24
 */

namespace app\api\controller;

use app\api\model\Log;
use app\common\controller\Base;

class LogController extends Base
{
    public function getAllLog(Log $log)
    {
        $page = $this->request->param('page');
        $rows = $this->request->param('rows');
        return json([
            'rows' => $log->getSysActionLog($page,$rows),
            'total'=>200//显示 200 条就可以啦.
        ]);
    }
}