/**
 * Created by Administrator on 2017/9/19.
 */

$(function($){
    $('#user').combobox({
        value:"111",
        panelHeight:"auto",
        url:'/ui/home/getUserNameList',
        valueField:'name',
        textField:'name'
    })
})


