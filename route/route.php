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
    'Create'	    =>	'api/Data/create',
    'Edit/:id'	    =>	'api/Data/edit',
    'EditOne/:id'   =>  'api/Data/getOneRow',
    'DGlist'        =>  'api/Data/getDglist',
    'SouSou'        =>  'api/Data/sousou',
    'refund/:id'    =>  'api/Data/refund',
    'shebao/:id'    =>  'api/Data/shebao',
    'refurn/:id'    =>  'api/Data/refurn',
    'commit/:id'    =>  'api/Data/commit',
    'sign/:id'      =>  'api/Data/sign',
    'prepareSubmit/:id' =>  'api/Data/prepareSubmit',
    'submit/:id'    =>  'api/Data/submit',
    'takeDiaol/:id' =>  'api/Data/takeDiaol',
    'finish/:id'    =>  'api/Data/finish',
    'etcinput/:id'  =>  'api/Data/etcinput',
    'comment/:id'   =>  'api/Data/comment',
    'tag/:id'       =>  'api/Data/tag',
    'getRcDate/:id' =>  'api/data/getRcDate',
    'getOneData/:id'=>  'api/data/getOneData'
]);
Route::group('task',[
    'create/[:id]'        => 'api/Task/create',
    'List'                => 'api/Task/TList',
    'Finish/:id'          => 'api/Task/Finish',
    'failed/:id'         => 'api/Task/failed'
]);
Route::group('ui',[
    'main'	    =>	'ui/Index/index',
    'login'	    =>	'ui/login/index',
    'Settings'  =>  'ui/Index/Settings',
    'log'       =>  'ui/index/Log',
    'task'      =>  'ui/index/Task',
]);

Route::group('menu',[
    'GetAll'      => 'api/menu/getSidebarAll',
    'Get/:tag'    => 'api/menu/getSidebar',
    'create'      => 'api/menu/create',
    'delete/:id'  => 'api/menu/delete',
]);

Route::group('log',[
    'GetAll'  => 'api/log/getAllLog',
]);

Route::group('combobox',[
    'Get/:tag'  =>  'api/combobox/get',
    'Userlist'  =>  'api/combobox/userlist'
]);

Route::group('user',[
    'doLogin' => 'api/User/dologin',
    'logout'  => 'api/User/logout'
]);

