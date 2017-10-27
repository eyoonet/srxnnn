# Host: localhost  (Version: 5.5.53)
# Date: 2017-10-27 22:00:11
# Generator: MySQL-Front 5.3  (Build 4.234)


#
# Data for table "auth_user_html"
#

INSERT INTO `auth_user_html` (`id`,`group_id`,`key`,`html`,`title`) VALUES 
(1,0,'buttions','<a onclick=\"ButtonRunDialog(this);\" dialog=\"add\" url=\"data/Create\" class=\"easyui-linkbutton\" plain=\"true\">添加</a>','添加'),
(2,0,'buttions','<a onclick=\"ButtonRunDialog(this);\" dialog=\"add\" url=\"data/Edit\" load=\"true\" class=\"easyui-linkbutton\"plain=\"true\">修改</a>','修改'),
(3,1,'buttions','<a onclick=\"ButtonRunDialog(this);\" dialog=\"comment\" url=\"data/refund\" load=\"true\" class=\"easyui-linkbutton\" plain=\"true\">退款</a>','退款'),
(4,1,'buttions','<a onclick=\"run(this)\" url=\"data/back\" class=\"easyui-linkbutton\" plain=\"true\">退回</a>','退回'),
(5,0,'buttions','<a onclick=\"run(this)\" url=\"data/shebao\" class=\"easyui-linkbutton\" plain=\"true\">无社保</a>','无社保'),
(6,0,'buttions','<a onclick=\"ButtonRunDialog(this);\" dialog=\"error\" url=\"data/refurn\" load=\"true\" class=\"easyui-linkbutton\" plain=\"true\">问题</a>','问题'),
(7,0,'buttions','<a onclick=\"run(this)\" url=\"data/etcinput\" class=\"easyui-linkbutton\" plain=\"true\">待录</a>','待录'),
(8,0,'buttions','<a onclick=\"ButtonRunDialog(this);\" dialog=\"commit\" url=\"data/commit\" load=\"true\" class=\"easyui-linkbutton\" plain=\"true\">提交</a>\n','提交'),
(9,0,'buttions','<a onclick=\"run(this)\" url=\"data/setAppointment\" class=\"easyui-linkbutton\" plain=\"true\">约号</a>','约号'),
(10,0,'buttions','<a onclick=\"run(this)\" url=\"data/sign\" class=\"easyui-linkbutton\" plain=\"true\">一审</a>','一审'),
(11,0,'buttions','<a onclick=\"run(this)\" url=\"data/prepareSubmit\" class=\"easyui-linkbutton\" plain=\"true\">预备二审</a>','预备二审'),
(12,0,'buttions','<a onclick=\"run(this)\" url=\"data/submit\" class=\"easyui-linkbutton\" plain=\"true\">二审</a>','二审'),
(13,0,'buttions','<a onclick=\"run(this)\" url=\"data/takeDiaol\" class=\"easyui-linkbutton\" plain=\"true\">拿调令</a>','拿调令'),
(14,0,'buttions','<a onclick=\"run(this)\" url=\"data/finish\" class=\"easyui-linkbutton\" plain=\"true\">完结</a>','完结'),
(15,0,'buttions','<a onclick=\"run(this)\" action=\"miss\" class=\"easyui-linkbutton\" plain=\"true\">爽约</a>','爽约'),
(16,0,'buttions','<a onclick=\"run(this)\" url=\"data/NuserCallin\" class=\"easyui-linkbutton\" plain=\"true\">调入</a>','调入'),
(17,0,'buttions','<a onclick=\"ButtonRunDialog(this);\" dialog=\"task\" url=\"task/create\" load=\"true\" class=\"easyui-linkbutton\" plain=\"true\">任务</a>','任务'),
(18,0,'buttions','<a id=\"comm-but\" onclick=\"ButtonRunDialog(this);\" dialog=\"comment\" url=\"data/comment\" load=\"true\"  class=\"easyui-linkbutton\" plain=\"true\">备注</a>','备注'),
(19,0,'buttions','<a id=\"tag-but\" onclick=\"ButtonRunDialog(this);\" dialog=\"tag\" url=\"data/tag\" load=\"true\"  class=\"easyui-linkbutton\" plain=\"true\">标记</a>','标记'),
(20,1,'adds','<li>\n    <label>所属用户</label>\n    <input name=\"user_id\" class=\"easyui-combobox\"\n           data-options=\"panelHeight:\'auto\',\n           url:\'combobox/Userlist\',\n           valueField:\'value\',\n           textField:\'text\',\n           editable:true\">\n</li>','所属用户'),
(21,1,'adds','<li>\n    <label>内勤</label>\n    <input name=\"nuser_id\" class=\"easyui-combobox\"\n           data-options=\"panelHeight:\'auto\',\n           url:\'combobox/Userlist\',\n           valueField:\'value\',\n           textField:\'text\',\n           editable:true\">\n</li>','内勤'),
(22,1,'adds','<li>\n    <label>外勤</label>\n    <input name=\"wuser_id\" class=\"easyui-combobox\"\n           data-options=\"panelHeight:\'auto\',\n           url:\'combobox/Userlist\',\n           valueField:\'value\',\n           textField:\'text\',\n           editable:true\">\n</li>','外勤'),
(23,1,'filter','<label>所属用户</label>\r\n<select name=\"user_id\" class=\"easyui-combobox\"\r\n        data-options=\"cls:\'filterinput\',\r\n              multiple:true,\r\n              multivalue:false,\r\n              url:\'combobox/Userlist\',\r\n              valueField:\'value\',\r\n              textField:\'text\',\r\n              editable:true\">\r\n</select>','业务员');
