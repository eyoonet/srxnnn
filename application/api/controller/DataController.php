<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/27
 * Time: 21:51
 */
namespace app\api\controller;
use app\api\model\Data;
use app\common\controller\Base;
use app\common\org\Res;
use think\Response;

class DataController extends Base
{
    public function  create(Data $sqldata){
        $data = $this->request->param();
        $validate = new \app\api\validate\Data();
        if($validate->check($data)){
             if( $sqldata->save($data)){
                 return Res::Json(200);
             }
        }else{
            return Res::Json(400,$validate->getError());
        }
    }
    public function edit( $id ){
        $data = $this->request->post();
        $validate = new \app\api\validate\Data();
        if($validate->scene('edit')->check($data)){
            $sqldata  = new Data();
            if( $sqldata->save($data,[ 'id'=>$id ]) ){
                return Res::Json(200);
            } else {
                return Res::Json(400);
            }
        } else {
            return Res::json(400,$validate->getError());
        }
    }
    public function getOneRow($id){
        $row = Data::get($id);
        if($row){
            return json($row->getData());
        }
    }
    //sort:rcdate  rows:15  page:1  order:desc
    public function getDglist(Data $sqldata){
        //请求说明 $params为排序分页 $rule 是查询规则 $fieids 是绑定参数
        $params  = $this->request->only(['page','rows','sort','order'], 'post');
        $rule   = $this->request->post('rule');
        $fieids = $this->request->except(['page','rows','sort','order','rule','type'], 'post');
        $type   = $this->request->post('type');
        if($type == 'sousou'){
            $lists =  $sqldata->search($params['page'],$params['rows'],$fieids);
        }else{
            if($rule == null || $fieids== null){ // 没有条件显示所有
                $rule = "1 = :id";
                $fieids = ['id'=>1 ];
            }
            $lists  = $sqldata->getDgList($params['page'],$params['rows'],$rule,$fieids);
        }
        return json([
            'rows'  => $lists,
            'total' => $sqldata->total(),
            'type'  => $type
        ]);
    }
}