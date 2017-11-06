<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
function res($code = 200,$msg = '操作成功!', $data=array() ){
    return json(['code'=>$code,'msg'=>$msg,'data'=>$data]);
}

/**
 * 时间差计算  这里只提供月差
 * @parem  int $begin   开始时间
 * @parem  int $end     结束时间
 */
function date_month_diff($begin, $end){
//    if(!$begin || $end) return FALSE;
    $begin = intval($begin);
    $end= intval($end);
    //计算月份差
    $mon = date('m', $end) - date('m', $begin);
    //计算月份差
    $day = date('d', $end) - date('d', $begin);
    //计算年份差
    $y  = date('y', $end) - date('y', $begin);
    //如果结束日期的天  减去  开始时间的天数   小于  0   &&  并且 月份相减的差 等于 1
    if($day < 0 && $mon == 1){
        //begin的当月最大天数
        $begin_m_d_n = date('t', $begin);
        //begin的当天数值
        $begin_day = date('d', $begin);
        $day = (date('d', $end)) + ($begin_m_d_n  - $begin_day);
    }
    //如果年份不同
    if( $y>0){
        //累加月份
        $mon +=  $y*12;
    }
    $datedif = array('mon' => $mon, 'day' => $day);
    return $datedif;
}