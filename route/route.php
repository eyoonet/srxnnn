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
Route::rule('test', 'api/Index/test');
Route::group('data',[
    'Create'	    =>	'api/Data/create',
    'Edit/:id'	    =>	'api/Data/edit',
    'EditOne/:id'   =>  'api/Data/getOneRow',
    'DGlist'        =>  'api/Data/getDglist',
    'SouSou'        =>  'api/Data/sousou'
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
]);

Route::group('user',[
    'doLogin' => 'api/User/dologin',
    'logout'  => 'api/User/logout'
]);

