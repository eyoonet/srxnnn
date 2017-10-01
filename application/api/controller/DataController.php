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
        if($validate->check($data)){
            $sqldata  = Data::get($id);
            if( $sqldata->isUpdate(true)->save($data) ){
                return Res::Json(200);
            } else {
                return Res::Json(400);
            }
        }
    }

    //sort:rcdate  rows:15  page:1  order:desc
    public function getDglist(Data $sqldata){
        //请求说明 $params为排序分页 $rule 是查询规则 $fieids 是绑定参数
        $prams  = $this->request->only(['page','rows','sort','order'], 'post');
        $rule   = $this->request->post('rule');
        $fieids = $this->request->except(['page','rows','sort','order','rule'], 'post');
        $lists  = $sqldata->getDgList($prams['page'],$prams['rows'],$rule,$fieids);
        return json([
            'rows'  => $lists,
            'total' => $sqldata->total()
        ]);
    }
    public function sousou(Data $sqldata){

    }
}