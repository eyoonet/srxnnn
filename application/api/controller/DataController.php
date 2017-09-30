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
    public function getDglist(Data $sqldata){

    }
}