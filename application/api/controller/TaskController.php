<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/6
 * Time: 0:55
 */
namespace app\api\controller;
use app\api\model\Task;
use app\common\controller\Base;
use app\common\org\Res;
class TaskController extends Base
{
    public function create(Task $m,$id = 0){
        $data = $this->request->post();
        $data['se_by_id']  = $this->uid;
        $data['clents_id'] = $id;
        return $m->save($data) ? Res::Json(200) : Res::Json(400);
    }
    public function TList(Task $m){
        $params = $this->request->only(['page','rows','sort','order'], 'post');
        $rule   = $this->request->post('rule');
        $fieids = $this->request->except(['page','rows','sort','order','rule','type'], 'post');
        $type   = $this->request->post('type');
        if($type == 'sousou'){
            //$lists =  $m->search($params['page'],$params['rows'],$fieids);
        }else{
            if($rule == null || $fieids== null){ // 没有条件显示所有
                $rule = "1 = :id";
                $fieids = ['id'=>1 ];
            }
            $lists  = $m->TList($params['page'],$params['rows'],$rule,$fieids);
        }
        return json([
            'rows'  => $lists,
            'total' => $m->total(),
            'type'  => $type
        ]);
    }
}