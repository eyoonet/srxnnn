ALTER TABLE `data`

MODIFY COLUMN `dangan`  varchar(2) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '调档' AFTER `zdtype`;
/*user   1杜清玲 2叶艳萍 4王桂参 5龙燕 6谭艳 7马青丽 12全老师*/
UPDATE  `oldsrxnnn`.`data` SET  `user` = "2" WHERE  `data`.`user` ="杜清玲";
UPDATE  `oldsrxnnn`.`data` SET  `user` = "3" WHERE  `data`.`user` ="叶艳萍";
UPDATE  `oldsrxnnn`.`data` SET  `user` = "4" WHERE  `data`.`user` ="王桂参";
UPDATE  `oldsrxnnn`.`data` SET  `user` = "5" WHERE  `data`.`user` ="龙艳";
UPDATE  `oldsrxnnn`.`data` SET  `user` = "6" WHERE  `data`.`user` ="谭艳";
UPDATE  `oldsrxnnn`.`data` SET  `user` = "7" WHERE  `data`.`user` ="马青丽";
UPDATE  `oldsrxnnn`.`data` SET  `user` = "12" WHERE  `data`.`user` ="全老师";
/*设置内勤刘晓娴*/
UPDATE  `srxnnn`.`data` SET  `nuser_id` = 9
/*service 
暂无 -1 外服 101 罗湖 102 龙华 103 龙岗 104 高新区 105  中心区 106
  
  龙华(区局) 201 福田(区局) 202 南山(区局) 203 罗湖(区局) 204 光明(区局) 205 盐田(区局) 206
  
  单位(自己) 300 单位(邦芒) 301 单位(一牛) 302 单位(永安) 303 单位(神鹰) 304
  */
UPDATE  `oldsrxnnn`.`data` SET  `service` = "101" WHERE  `data`.`service` ="外服";
UPDATE  `oldsrxnnn`.`data` SET  `service` = "102" WHERE  `data`.`service` ="罗湖";
UPDATE  `oldsrxnnn`.`data` SET  `service` = "103" WHERE  `data`.`service` ="龙华";
UPDATE  `oldsrxnnn`.`data` SET  `service` = "104" WHERE  `data`.`service` ="龙岗";
UPDATE  `oldsrxnnn`.`data` SET  `service` = "105" WHERE  `data`.`service` ="南山";
UPDATE  `oldsrxnnn`.`data` SET  `service` = "105" WHERE  `data`.`service` ="南山高新";
UPDATE  `oldsrxnnn`.`data` SET  `service` = "105" WHERE  `data`.`service` ="高新区分部";
UPDATE  `oldsrxnnn`.`data` SET  `service` = "105" WHERE  `data`.`service` ="高新区";
UPDATE  `oldsrxnnn`.`data` SET  `service` = "105" WHERE  `data`.`service` ="高新";
UPDATE  `oldsrxnnn`.`data` SET  `service` = "106" WHERE  `data`.`service` ="中心区";
UPDATE  `oldsrxnnn`.`data` SET  `service` = "202" WHERE  `data`.`service` ="福田区局";
UPDATE  `oldsrxnnn`.`data` SET  `service` = "202" WHERE  `data`.`service` ="福田区人力资源";
UPDATE  `oldsrxnnn`.`data` SET  `service` = "204" WHERE  `data`.`service` ="罗湖区局";
UPDATE  `oldsrxnnn`.`data` SET  `service` = "300" WHERE  `data`.`service` ="公司单位";
UPDATE  `oldsrxnnn`.`data` SET  `service` = "300" WHERE  `data`.`service` ="自己单位";
UPDATE  `oldsrxnnn`.`data` SET  `service` = "301" WHERE  `data`.`service` ="帮忙";
UPDATE  `oldsrxnnn`.`data` SET  `service` = "303" WHERE  `data`.`service` ="光明";
UPDATE  `oldsrxnnn`.`data` SET  `service` = "" WHERE  `data`.`service` ="市局";
/* mode   模式: 核准 12 积分 11 应届生03 留学生 05 */
UPDATE  `oldsrxnnn`.`data` SET  `mode` = "03" WHERE  `data`.`mode` ="应届生";
UPDATE  `oldsrxnnn`.`data` SET  `mode` = "05" WHERE  `data`.`mode` ="留学生";
UPDATE  `oldsrxnnn`.`data` SET  `mode` = "11" WHERE  `data`.`mode` ="积分制";
UPDATE  `oldsrxnnn`.`data` SET  `mode` = "12" WHERE  `data`.`mode` ="核准制";
/* zdtype 招调类型(01.招工02.调干) */
UPDATE  `oldsrxnnn`.`data` SET  `zdtype` = "01" WHERE  `data`.`zdtype` ="招工";
UPDATE  `oldsrxnnn`.`data` SET  `zdtype` = "02" WHERE  `data`.`zdtype` ="调干";
/* sbtype 申报类型(1.个人2.单位) */
UPDATE  `oldsrxnnn`.`data` SET  `sbtype` = "1" WHERE  `data`.`sbtype` ="个人申报";
UPDATE  `oldsrxnnn`.`data` SET  `sbtype` = "2" WHERE  `data`.`sbtype` ="单位申报";
/* order  订单 1 正常 -1 退款 */
UPDATE  `oldsrxnnn`.`data` SET  `order` = "-1" WHERE  `data`.`order` ="退款";
UPDATE  `oldsrxnnn`.`data` SET  `order` = "1" WHERE  `data`.`order` is null;
/* dangan 调档 -1 | 1 */
UPDATE  `oldsrxnnn`.`data` SET  `dangan` = "-1" WHERE  `data`.`dangan` ="否";
UPDATE  `oldsrxnnn`.`data` SET  `dangan` = "1" WHERE  `data`.`dangan` ="是";
/* wuser  外勤张 8 外勤易 11 */
UPDATE  `oldsrxnnn`.`data` SET  `wuser` = "8" WHERE  `data`.`wuser` ="外勤张";
UPDATE  `oldsrxnnn`.`data` SET  `wuser` = "11" WHERE  `data`.`wuser` ="外勤易";
/*      -1  => '新进客户', 1  => '没有社保',   2 => '问题打回',  3 => '待录人保',
         4  => '提交人保', 5  => '已约号I',    6 => '已约号II',  7 => '已出号',
         8  => '已一审',   9  => '预备二审',  10 => '已二审',   11 => '撤销终止',
         12 => '不予受理', 13 => '待报道',    14 => '审批中',   15 => '审批同意',
         16 => '出调令',   17 => '已拿调令',  18 => '完结', */
UPDATE  `oldsrxnnn`.`data` SET  `status` = "-1" WHERE  `data`.`status` ="新进客户";
UPDATE  `oldsrxnnn`.`data` SET  `status` = "1" WHERE  `data`.`status` ="没有社保";
UPDATE  `oldsrxnnn`.`data` SET  `status` = "2" WHERE  `data`.`status` ="问题打回";
UPDATE  `oldsrxnnn`.`data` SET  `status` = "3" WHERE  `data`.`status` ="待录人保";
UPDATE  `oldsrxnnn`.`data` SET  `status` = "4" WHERE  `data`.`status` ="提交人保";
UPDATE  `oldsrxnnn`.`data` SET  `status` = "5" WHERE  `data`.`status` ="已约号";
UPDATE  `oldsrxnnn`.`data` SET  `status` = "6" WHERE  `data`.`status` ="已约号II";
UPDATE  `oldsrxnnn`.`data` SET  `status` = "7" WHERE  `data`.`status` ="已出号";
UPDATE  `oldsrxnnn`.`data` SET  `status` = "8" WHERE  `data`.`status` ="预备二审";
UPDATE  `oldsrxnnn`.`data` SET  `status` = "9" WHERE  `data`.`status` ="可以二审";
UPDATE  `oldsrxnnn`.`data` SET  `status` = "10" WHERE  `data`.`status` ="等待调令";
UPDATE  `oldsrxnnn`.`data` SET  `status` = "11" WHERE  `data`.`status` ="已撤销（终止）";
UPDATE  `oldsrxnnn`.`data` SET  `status` = "12" WHERE  `data`.`status` ="不予受理";
UPDATE  `oldsrxnnn`.`data` SET  `status` = "13" WHERE  `data`.`status` ="待报到";
UPDATE  `oldsrxnnn`.`data` SET  `status` = "14" WHERE  `data`.`status` ="审批中";
UPDATE  `oldsrxnnn`.`data` SET  `status` = "15" WHERE  `data`.`status` ="已审批同意";
UPDATE  `oldsrxnnn`.`data` SET  `status` = "16" WHERE  `data`.`status` ="出调令";
UPDATE  `oldsrxnnn`.`data` SET  `status` = "17" WHERE  `data`.`status` ="已拿调令";
UPDATE  `oldsrxnnn`.`data` SET  `status` = "18" WHERE  `data`.`status` ="完结";

UPDATE  `oldsrxnnn`.`data` SET  `status` = "100" WHERE  `data`.`status` ="派单外勤";
UPDATE  `oldsrxnnn`.`data` SET  `status` = "101" WHERE  `data`.`status` ="拿证";
UPDATE  `oldsrxnnn`.`data` SET  `status` = "102" WHERE  `data`.`status` ="外处理";
/* speed  进度 -1 未办 1 一审 2 二审 3 完结 */
UPDATE  `oldsrxnnn`.`data` SET  `speed` = "-1" WHERE  `data`.`speed` ="未办";
UPDATE  `oldsrxnnn`.`data` SET  `speed` = "1" WHERE  `data`.`speed` ="一审";
UPDATE  `oldsrxnnn`.`data` SET  `speed` = "2" WHERE  `data`.`speed` ="二审";
UPDATE  `oldsrxnnn`.`data` SET  `speed` = "3" WHERE  `data`.`speed` ="完结";
/* address  落户地 1窗口集体户 2自己房产 3亲友房产 4单位集体户 5我们提供 */
UPDATE  `oldsrxnnn`.`data` SET  `adderss` = "1" WHERE  `data`.`adderss` ="中心区";
UPDATE  `oldsrxnnn`.`data` SET  `adderss` = "1" WHERE  `data`.`adderss` ="南园";
UPDATE  `oldsrxnnn`.`data` SET  `adderss` = "1" WHERE  `data`.`adderss` ="窗口集体";
UPDATE  `oldsrxnnn`.`data` SET  `adderss` = "2" WHERE  `data`.`adderss` ="自己";
UPDATE  `oldsrxnnn`.`data` SET  `adderss` = "3" WHERE  `data`.`adderss` ="挂靠朋友";
UPDATE  `oldsrxnnn`.`data` SET  `adderss` = "4" WHERE  `data`.`adderss` ="单位集体";
/* child  -1 无 1一个 2二个 3怀孕 4随迁 */
UPDATE  `oldsrxnnn`.`data` SET  `child` = "-1" WHERE  `data`.`child` ="无";
UPDATE  `oldsrxnnn`.`data` SET  `child` = "-1" WHERE  `data`.`child` ="";
UPDATE  `oldsrxnnn`.`data` SET  `child` = "1" WHERE  `data`.`child` ="一孩";
UPDATE  `oldsrxnnn`.`data` SET  `child` = "2" WHERE  `data`.`child` ="二孩";
UPDATE  `oldsrxnnn`.`data` SET  `child` = "3" WHERE  `data`.`child` ="怀孕";
/* education 学历:01博士.02硕士.03本科.04大专 */
UPDATE  `oldsrxnnn`.`data` SET  `education` = "01" WHERE  `data`.`education` ="博士";
UPDATE  `oldsrxnnn`.`data` SET  `education` = "02" WHERE  `data`.`education` ="硕士";
UPDATE  `oldsrxnnn`.`data` SET  `education` = "03" WHERE  `data`.`education` ="本科";
UPDATE  `oldsrxnnn`.`data` SET  `education` = "04" WHERE  `data`.`education` ="大专";
/* marriage 01未婚 02已婚 03离异 04 复婚 05 再婚 06丧偶 */
UPDATE  `oldsrxnnn`.`data` SET  `marriage` = "01" WHERE  `data`.`marriage` ="未婚";
UPDATE  `oldsrxnnn`.`data` SET  `marriage` = "02" WHERE  `data`.`marriage` ="已婚";
UPDATE  `oldsrxnnn`.`data` SET  `marriage` = "03" WHERE  `data`.`marriage` ="离异";
UPDATE  `oldsrxnnn`.`data` SET  `marriage` = "03" WHERE  `data`.`marriage` ="离婚";
UPDATE  `oldsrxnnn`.`data` SET  `marriage` = "04" WHERE  `data`.`marriage` ="复婚";
UPDATE  `oldsrxnnn`.`data` SET  `marriage` = "05" WHERE  `data`.`marriage` ="再婚";
UPDATE  `oldsrxnnn`.`data` SET  `marriage` = "-1" WHERE  `data`.`marriage` ="";
/* shop   三人行 1  t7 2 永安 3 48g 4 马 5 转介绍 6 百度 7  */
UPDATE  `oldsrxnnn`.`data` SET  `shop` = "1" WHERE  `data`.`shop` ="三人行";
UPDATE  `oldsrxnnn`.`data` SET  `shop` = "2" WHERE  `data`.`shop` ="t7";
UPDATE  `oldsrxnnn`.`data` SET  `shop` = "3" WHERE  `data`.`shop` ="永安";
UPDATE  `oldsrxnnn`.`data` SET  `shop` = "5" WHERE  `data`.`shop` ="马";
UPDATE  `oldsrxnnn`.`data` SET  `shop` = "4" WHERE  `data`.`shop` ="48g";
UPDATE  `oldsrxnnn`.`data` SET  `shop` = "-1" WHERE  `data`.`shop` ="无";
UPDATE  `oldsrxnnn`.`data` SET  `shop` = "-1" WHERE  `data`.`shop` ="";



ALTER TABLE `data`
CHANGE COLUMN `Id` `id`  int(11) NOT NULL AUTO_INCREMENT FIRST ,
MODIFY COLUMN `renbao_user`  varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '人保账号' AFTER `wangwang`,
MODIFY COLUMN `renbao_password`  varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '密码' AFTER `renbao_user`,
MODIFY COLUMN `price`  double NULL DEFAULT NULL COMMENT '价格' AFTER `renbao_password`,
MODIFY COLUMN `deposit`  double NULL DEFAULT NULL COMMENT '订金' AFTER `price`,
MODIFY COLUMN `shop`  varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '店铺' AFTER `deposit`,
CHANGE COLUMN `user` `user_id`  varchar(5) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '操作员' AFTER `shop`,
MODIFY COLUMN `marriage`  varchar(2) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '婚姻' AFTER `user_id`,
MODIFY COLUMN `marrDate`  varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '结婚日期' AFTER `marriage`,
MODIFY COLUMN `child`  varchar(2) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '小孩信息' AFTER `marrDate`,
MODIFY COLUMN `schoolName`  varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '毕业学校' AFTER `education`,
MODIFY COLUMN `major`  varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '专业' AFTER `schoolName`,
MODIFY COLUMN `graduateDate`  varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '毕业日期' AFTER `major`,
MODIFY COLUMN `order`  varchar(4) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '定单状态' AFTER `graduateDate`,
MODIFY COLUMN `sbtype`  varchar(4) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '个人申报' COMMENT '申报类型' AFTER `mode`,
MODIFY COLUMN `zdtype`  varchar(2) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '招工' COMMENT '招调类型' AFTER `sbtype`,
MODIFY COLUMN `dangan`  varchar(5) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '调档' AFTER `zdtype`,
MODIFY COLUMN `adderss`  varchar(4) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '迁入地' AFTER `dangan`,
MODIFY COLUMN `status`  varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '新进客户' COMMENT '状态' AFTER `adderss`,
MODIFY COLUMN `service`  varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '服务地' AFTER `speed`,
MODIFY COLUMN `shebao`  varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '社保' AFTER `service`,
MODIFY COLUMN `shebaoname`  varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '社保公司' AFTER `shebao`,
MODIFY COLUMN `txadderss`  varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '通讯地址' AFTER `shebaoname`,
MODIFY COLUMN `rcdate`  varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '人才网返回时间' AFTER `txadderss`,
MODIFY COLUMN `add_time`  int(10) NULL DEFAULT NULL COMMENT '添加时间' AFTER `rcdate`,
MODIFY COLUMN `I_date`  int(11) NULL DEFAULT NULL COMMENT '一审记录' AFTER `speed_time`,
MODIFY COLUMN `II_date`  int(11) NULL DEFAULT NULL COMMENT '二审记录' AFTER `I_date`,
MODIFY COLUMN `Tag`  varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL AFTER `II_date`,
ADD COLUMN `pay_mode`  varchar(255) NULL AFTER `deposit`,
ADD COLUMN `nuser_id`  int NULL AFTER `user_id`,
ADD COLUMN `wuser_id`  int NULL AFTER `nuser_id`,
ADD COLUMN `dangan_ads`  varchar(255) NULL AFTER `dangan`,
ADD COLUMN `place`  varchar(255) NULL AFTER `service`,
ADD COLUMN `area`  varchar(255) NULL AFTER `shebaoname`;