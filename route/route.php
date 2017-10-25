<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

/*
Route::get('think', function () {
    return 'hello,ThinkPHP5!';
});
*/
Route::rule('test', 'api/Index/index');
Route::group('data',[
    'Create'                =>	'api/Data/create',                  //创建
    'Edit/:id'              =>	'api/Data/edit',                    //编辑
    'EditOne/:id'           =>  'api/Data/getOneRow',               //获取一条数据
    'DGlist'                =>  'api/Data/getDglist',               //菜单列表数据
    'SouSou'                =>  'api/Data/sousou',                  //搜索
    'refund/:id'            =>  'api/Data/refund',                  //退款
    'shebao/:id'            =>  'api/Data/shebao',                  //没有社保
    'refurn/:id'            =>  'api/Data/refurn',                  //问题打回
    'commit/:id'            =>  'api/Data/commit',                  //提交人保
    'sign/:id'              =>  'api/Data/sign',                    //一审
    'prepareSubmit/:id'     =>  'api/Data/prepareSubmit',           //预备二审
    'submit/:id'            =>  'api/Data/submit',                  //二审
    'takeDiaol/:id'         =>  'api/Data/takeDiaol',               //已拿调令
    'finish/:id'            =>  'api/Data/finish',                  //完成
    'etcinput/:id'          =>  'api/Data/etcinput',                //待录人保
    'comment/:id'           =>  'api/Data/comment',                 //设置备注
    'tag/:id'               =>  'api/Data/tag',                     //设置标签
    'getRcDate/:id'         =>  'api/data/getRcDate',               //获取人才网约号时间
    'setRcDate/:id/:time'   =>  'api/data/setRcDate',               //设置人才网返回的约号时间
    'getOneData/:id'        =>  'api/data/getOneData',              //获取单条数据
    'setAppointment/:id'    =>  'api/data/setAppointment',          //设置状态为已约号
    'getAppointment'        =>  'api/data/getAppointmentList',      //获取已约号的列表
    'getSubmitList'         =>  'api/data/getSubmitList',           //获取已经二审的列表
    'NuserCallin/:id'       =>  'api/data/NuserCallin',             //内勤调入
    'getAuditSuccessList'   =>  'api/data/getAuditSuccessList',     //获取审批完成的列表
    'setSzhrss'             =>  'api/data/setSzhrss',               //设置人保局进度
    'upload'                =>  'api/data/uploadByImage',           //图片上传
    'imageList'             =>  'api/data/imageList',               //证件列表
    'back/:id'              =>  'api/data/back'                     //后撤
]);
Route::group('task',[
    'create/[:id]/[:type]'          => 'api/Task/taskCreate',           //任务创建
    'taskForward/:id/[:clents_id]/[:type]'          => 'api/Task/taskForward',           //任务转发
    'List'                  => 'api/Task/taskList',            //任务列表
    'Finish/:id'            => 'api/Task/taskFinish',           //任务成功
    'failed/:id'            => 'api/Task/taskFailed'            //任务失败
]);
Route::group('ui',[
    'main'	    =>	'ui/Index/index',
    'login'	    =>	'ui/login/index',
    'Settings'  =>  'ui/Index/Settings',
    'log'       =>  'ui/index/Log',
    'task'      =>  'ui/index/Task',
    'upload'    =>  'ui/index/Upload',
    'mobile'    =>  'ui/index/Mobile',
    'downExcel' =>  'ui/index/downExcel'                    //下载excel表格
]);
Route::group('menu',[
    'GetAll'      => 'api/menu/getSidebarAll',              //获取所有
    'Get/:tag'    => 'api/menu/getSidebar',                 //获取左边
    'create'      => 'api/menu/create',                     //创建
    'delete/:id'  => 'api/menu/delete',                     //删除
    'edit/:id'  => 'api/menu/edit',                         //编辑
]);

Route::group('log',[
    'GetAll'  => 'api/log/getAllLog',
]);

Route::group('combobox',[
    'Get/:tag'    =>  'api/combobox/get',
    'Userlist'    =>  'api/combobox/userlist',
    'menuFidlist' =>  'api/combobox/menufidlist'
]);

Route::group('user',[
    'doLogin' => 'api/User/dologin',
    'logout'  => 'api/User/logout'
]);

