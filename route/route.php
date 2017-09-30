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

//Route::rule('test', 'api/Index/test');

return [
    'test'=>'api/Index/index',
    //'ui/[:name]'=>'ui/Index/index',
    '/'                  => 'ui/Index/index',
    'login'              => 'ui/login/index',
    'doLogin'            => 'api/User/dologin',
    'getSidebarAll'      => 'api/menu/getSidebarAll',
    'getSidebar/:tag'    => 'api/menu/getSidebar',
    'menu-add'           => 'api/menu/create',
    'menu-del/:id'       => 'api/menu/delete',
    'getCombobox/:tag'   => 'api/combobox/get',
    'getAllLog'          => 'api/log/getAllLog',
    'dataCreate'         => 'api/Data/create',
    'dataEdit/:id'           => 'api/Data/edit',
];
