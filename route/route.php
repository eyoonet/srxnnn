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
    //'test/:name'=>'api/Index/test',
    //'ui/[:name]'=>'ui/Index/index',
    '/'=>'ui/Index/index',
    'login'=>'ui/Index/login',
    'getSidebarAll'=>'api/menu/getSidebarAll',
    'getSidebar/:tag'=>'api/menu/getSidebar'
];
