ALTER TABLE `data`

MODIFY COLUMN `dangan`  varchar(2) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '����' AFTER `zdtype`;
/*user   1������ 2Ҷ��Ƽ 4����� 5���� 6̷�� 7������ 12ȫ��ʦ*/
UPDATE  `oldsrxnnn`.`data` SET  `user` = "2" WHERE  `data`.`user` ="������";
UPDATE  `oldsrxnnn`.`data` SET  `user` = "3" WHERE  `data`.`user` ="Ҷ��Ƽ";
UPDATE  `oldsrxnnn`.`data` SET  `user` = "4" WHERE  `data`.`user` ="�����";
UPDATE  `oldsrxnnn`.`data` SET  `user` = "5" WHERE  `data`.`user` ="����";
UPDATE  `oldsrxnnn`.`data` SET  `user` = "6" WHERE  `data`.`user` ="̷��";
UPDATE  `oldsrxnnn`.`data` SET  `user` = "7" WHERE  `data`.`user` ="������";
UPDATE  `oldsrxnnn`.`data` SET  `user` = "12" WHERE  `data`.`user` ="ȫ��ʦ";
/*service 
���� -1 ��� 101 �޺� 102 ���� 103 ���� 104 ������ 105  ������ 106
  
  ����(����) 201 ����(����) 202 ��ɽ(����) 203 �޺�(����) 204 ����(����) 205 ����(����) 206
  
  ��λ(�Լ�) 300 ��λ(��â) 301 ��λ(һţ) 302 ��λ(����) 303 ��λ(��ӥ) 304
  */
UPDATE  `oldsrxnnn`.`data` SET  `service` = "101" WHERE  `data`.`service` ="���";
UPDATE  `oldsrxnnn`.`data` SET  `service` = "102" WHERE  `data`.`service` ="�޺�";
UPDATE  `oldsrxnnn`.`data` SET  `service` = "103" WHERE  `data`.`service` ="����";
UPDATE  `oldsrxnnn`.`data` SET  `service` = "104" WHERE  `data`.`service` ="����";
UPDATE  `oldsrxnnn`.`data` SET  `service` = "105" WHERE  `data`.`service` ="��ɽ";
UPDATE  `oldsrxnnn`.`data` SET  `service` = "105" WHERE  `data`.`service` ="��ɽ����";
UPDATE  `oldsrxnnn`.`data` SET  `service` = "105" WHERE  `data`.`service` ="�������ֲ�";
UPDATE  `oldsrxnnn`.`data` SET  `service` = "105" WHERE  `data`.`service` ="������";
UPDATE  `oldsrxnnn`.`data` SET  `service` = "105" WHERE  `data`.`service` ="����";
UPDATE  `oldsrxnnn`.`data` SET  `service` = "106" WHERE  `data`.`service` ="������";
UPDATE  `oldsrxnnn`.`data` SET  `service` = "202" WHERE  `data`.`service` ="��������";
UPDATE  `oldsrxnnn`.`data` SET  `service` = "202" WHERE  `data`.`service` ="������������Դ";
UPDATE  `oldsrxnnn`.`data` SET  `service` = "204" WHERE  `data`.`service` ="�޺�����";
UPDATE  `oldsrxnnn`.`data` SET  `service` = "300" WHERE  `data`.`service` ="��˾��λ";
UPDATE  `oldsrxnnn`.`data` SET  `service` = "300" WHERE  `data`.`service` ="�Լ���λ";
UPDATE  `oldsrxnnn`.`data` SET  `service` = "301" WHERE  `data`.`service` ="��æ";
UPDATE  `oldsrxnnn`.`data` SET  `service` = "303" WHERE  `data`.`service` ="����";
UPDATE  `oldsrxnnn`.`data` SET  `service` = "" WHERE  `data`.`service` ="�о�";
/* mode   ģʽ: ��׼ 12 ���� 11 Ӧ����03 ��ѧ�� 05 */
UPDATE  `oldsrxnnn`.`data` SET  `mode` = "03" WHERE  `data`.`mode` ="Ӧ����";
UPDATE  `oldsrxnnn`.`data` SET  `mode` = "05" WHERE  `data`.`mode` ="��ѧ��";
UPDATE  `oldsrxnnn`.`data` SET  `mode` = "11" WHERE  `data`.`mode` ="������";
UPDATE  `oldsrxnnn`.`data` SET  `mode` = "12" WHERE  `data`.`mode` ="��׼��";
/* zdtype �е�����(01.�й�02.����) */
UPDATE  `oldsrxnnn`.`data` SET  `zdtype` = "01" WHERE  `data`.`zdtype` ="�й�";
UPDATE  `oldsrxnnn`.`data` SET  `zdtype` = "02" WHERE  `data`.`zdtype` ="����";
/* sbtype �걨����(1.����2.��λ) */
UPDATE  `oldsrxnnn`.`data` SET  `sbtype` = "1" WHERE  `data`.`sbtype` ="�����걨";
UPDATE  `oldsrxnnn`.`data` SET  `sbtype` = "2" WHERE  `data`.`sbtype` ="��λ�걨";
/* order  ���� 1 ���� -1 �˿� */
UPDATE  `oldsrxnnn`.`data` SET  `order` = "-1" WHERE  `data`.`order` ="�˿�";
UPDATE  `oldsrxnnn`.`data` SET  `order` = "1" WHERE  `data`.`order` is null;
/* dangan ���� -1 | 1 */
UPDATE  `oldsrxnnn`.`data` SET  `dangan` = "-1" WHERE  `data`.`dangan` ="��";
UPDATE  `oldsrxnnn`.`data` SET  `dangan` = "1" WHERE  `data`.`dangan` ="��";
/* wuser  ������ 8 ������ 11 */
UPDATE  `oldsrxnnn`.`data` SET  `wuser` = "8" WHERE  `data`.`wuser` ="������";
UPDATE  `oldsrxnnn`.`data` SET  `wuser` = "11" WHERE  `data`.`wuser` ="������";
/*      -1  => '�½��ͻ�', 1  => 'û���籣',   2 => '������',  3 => '��¼�˱�',
         4  => '�ύ�˱�', 5  => '��Լ��I',    6 => '��Լ��II',  7 => '�ѳ���',
         8  => '��һ��',   9  => 'Ԥ������',  10 => '�Ѷ���',   11 => '������ֹ',
         12 => '��������', 13 => '������',    14 => '������',   15 => '����ͬ��',
         16 => '������',   17 => '���õ���',  18 => '���', */
UPDATE  `oldsrxnnn`.`data` SET  `status` = "-1" WHERE  `data`.`status` ="�½��ͻ�";
UPDATE  `oldsrxnnn`.`data` SET  `status` = "1" WHERE  `data`.`status` ="û���籣";
UPDATE  `oldsrxnnn`.`data` SET  `status` = "2" WHERE  `data`.`status` ="������";
UPDATE  `oldsrxnnn`.`data` SET  `status` = "3" WHERE  `data`.`status` ="��¼�˱�";
UPDATE  `oldsrxnnn`.`data` SET  `status` = "4" WHERE  `data`.`status` ="�ύ�˱�";
UPDATE  `oldsrxnnn`.`data` SET  `status` = "5" WHERE  `data`.`status` ="��Լ��";
UPDATE  `oldsrxnnn`.`data` SET  `status` = "6" WHERE  `data`.`status` ="��Լ��II";
UPDATE  `oldsrxnnn`.`data` SET  `status` = "7" WHERE  `data`.`status` ="�ѳ���";
UPDATE  `oldsrxnnn`.`data` SET  `status` = "8" WHERE  `data`.`status` ="Ԥ������";
UPDATE  `oldsrxnnn`.`data` SET  `status` = "9" WHERE  `data`.`status` ="���Զ���";
UPDATE  `oldsrxnnn`.`data` SET  `status` = "10" WHERE  `data`.`status` ="�ȴ�����";
UPDATE  `oldsrxnnn`.`data` SET  `status` = "11" WHERE  `data`.`status` ="�ѳ�������ֹ��";
UPDATE  `oldsrxnnn`.`data` SET  `status` = "12" WHERE  `data`.`status` ="��������";
UPDATE  `oldsrxnnn`.`data` SET  `status` = "13" WHERE  `data`.`status` ="������";
UPDATE  `oldsrxnnn`.`data` SET  `status` = "14" WHERE  `data`.`status` ="������";
UPDATE  `oldsrxnnn`.`data` SET  `status` = "15" WHERE  `data`.`status` ="������ͬ��";
UPDATE  `oldsrxnnn`.`data` SET  `status` = "16" WHERE  `data`.`status` ="������";
UPDATE  `oldsrxnnn`.`data` SET  `status` = "17" WHERE  `data`.`status` ="���õ���";
UPDATE  `oldsrxnnn`.`data` SET  `status` = "18" WHERE  `data`.`status` ="���";

UPDATE  `oldsrxnnn`.`data` SET  `status` = "100" WHERE  `data`.`status` ="�ɵ�����";
UPDATE  `oldsrxnnn`.`data` SET  `status` = "101" WHERE  `data`.`status` ="��֤";
UPDATE  `oldsrxnnn`.`data` SET  `status` = "102" WHERE  `data`.`status` ="�⴦��";
/* speed  ���� -1 δ�� 1 һ�� 2 ���� 3 ��� */
UPDATE  `oldsrxnnn`.`data` SET  `speed` = "-1" WHERE  `data`.`speed` ="δ��";
UPDATE  `oldsrxnnn`.`data` SET  `speed` = "1" WHERE  `data`.`speed` ="һ��";
UPDATE  `oldsrxnnn`.`data` SET  `speed` = "2" WHERE  `data`.`speed` ="����";
UPDATE  `oldsrxnnn`.`data` SET  `speed` = "3" WHERE  `data`.`speed` ="���";
/* address  �仧�� 1���ڼ��廧 2�Լ����� 3���ѷ��� 4��λ���廧 5�����ṩ */
UPDATE  `oldsrxnnn`.`data` SET  `adderss` = "1" WHERE  `data`.`adderss` ="������";
UPDATE  `oldsrxnnn`.`data` SET  `adderss` = "1" WHERE  `data`.`adderss` ="��԰";
UPDATE  `oldsrxnnn`.`data` SET  `adderss` = "1" WHERE  `data`.`adderss` ="���ڼ���";
UPDATE  `oldsrxnnn`.`data` SET  `adderss` = "2" WHERE  `data`.`adderss` ="�Լ�";
UPDATE  `oldsrxnnn`.`data` SET  `adderss` = "3" WHERE  `data`.`adderss` ="�ҿ�����";
UPDATE  `oldsrxnnn`.`data` SET  `adderss` = "4" WHERE  `data`.`adderss` ="��λ����";
/* child  -1 �� 1һ�� 2���� 3���� 4��Ǩ */
UPDATE  `oldsrxnnn`.`data` SET  `child` = "-1" WHERE  `data`.`child` ="��";
UPDATE  `oldsrxnnn`.`data` SET  `child` = "-1" WHERE  `data`.`child` ="";
UPDATE  `oldsrxnnn`.`data` SET  `child` = "1" WHERE  `data`.`child` ="һ��";
UPDATE  `oldsrxnnn`.`data` SET  `child` = "2" WHERE  `data`.`child` ="����";
UPDATE  `oldsrxnnn`.`data` SET  `child` = "3" WHERE  `data`.`child` ="����";
/* education ѧ��:01��ʿ.02˶ʿ.03����.04��ר */
UPDATE  `oldsrxnnn`.`data` SET  `education` = "01" WHERE  `data`.`education` ="��ʿ";
UPDATE  `oldsrxnnn`.`data` SET  `education` = "02" WHERE  `data`.`education` ="˶ʿ";
UPDATE  `oldsrxnnn`.`data` SET  `education` = "03" WHERE  `data`.`education` ="����";
UPDATE  `oldsrxnnn`.`data` SET  `education` = "04" WHERE  `data`.`education` ="��ר";
/* marriage 01δ�� 02�ѻ� 03���� 04 ���� 05 �ٻ� 06ɥż */
UPDATE  `oldsrxnnn`.`data` SET  `marriage` = "01" WHERE  `data`.`marriage` ="δ��";
UPDATE  `oldsrxnnn`.`data` SET  `marriage` = "02" WHERE  `data`.`marriage` ="�ѻ�";
UPDATE  `oldsrxnnn`.`data` SET  `marriage` = "03" WHERE  `data`.`marriage` ="����";
UPDATE  `oldsrxnnn`.`data` SET  `marriage` = "03" WHERE  `data`.`marriage` ="���";
UPDATE  `oldsrxnnn`.`data` SET  `marriage` = "04" WHERE  `data`.`marriage` ="����";
UPDATE  `oldsrxnnn`.`data` SET  `marriage` = "05" WHERE  `data`.`marriage` ="�ٻ�";
UPDATE  `oldsrxnnn`.`data` SET  `marriage` = "-1" WHERE  `data`.`marriage` ="";
/* shop   ������ 1  t7 2 ���� 3 48g 4 �� 5 ת���� 6 �ٶ� 7  */
UPDATE  `oldsrxnnn`.`data` SET  `shop` = "1" WHERE  `data`.`shop` ="������";
UPDATE  `oldsrxnnn`.`data` SET  `shop` = "2" WHERE  `data`.`shop` ="t7";
UPDATE  `oldsrxnnn`.`data` SET  `shop` = "3" WHERE  `data`.`shop` ="����";
UPDATE  `oldsrxnnn`.`data` SET  `shop` = "5" WHERE  `data`.`shop` ="��";
UPDATE  `oldsrxnnn`.`data` SET  `shop` = "4" WHERE  `data`.`shop` ="48g";
UPDATE  `oldsrxnnn`.`data` SET  `shop` = "-1" WHERE  `data`.`shop` ="��";
UPDATE  `oldsrxnnn`.`data` SET  `shop` = "-1" WHERE  `data`.`shop` ="";



ALTER TABLE `data`
CHANGE COLUMN `Id` `id`  int(11) NOT NULL AUTO_INCREMENT FIRST ,
MODIFY COLUMN `renbao_user`  varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '�˱��˺�' AFTER `wangwang`,
MODIFY COLUMN `renbao_password`  varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '����' AFTER `renbao_user`,
MODIFY COLUMN `price`  double NULL DEFAULT NULL COMMENT '�۸�' AFTER `renbao_password`,
MODIFY COLUMN `deposit`  double NULL DEFAULT NULL COMMENT '����' AFTER `price`,
MODIFY COLUMN `shop`  varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '����' AFTER `deposit`,
CHANGE COLUMN `user` `user_id`  varchar(5) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '����Ա' AFTER `shop`,
MODIFY COLUMN `marriage`  varchar(2) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '����' AFTER `user_id`,
MODIFY COLUMN `marrDate`  varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '�������' AFTER `marriage`,
MODIFY COLUMN `child`  varchar(2) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'С����Ϣ' AFTER `marrDate`,
MODIFY COLUMN `schoolName`  varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '��ҵѧУ' AFTER `education`,
MODIFY COLUMN `major`  varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'רҵ' AFTER `schoolName`,
MODIFY COLUMN `graduateDate`  varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '��ҵ����' AFTER `major`,
MODIFY COLUMN `order`  varchar(4) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '����״̬' AFTER `graduateDate`,
MODIFY COLUMN `sbtype`  varchar(4) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '�����걨' COMMENT '�걨����' AFTER `mode`,
MODIFY COLUMN `zdtype`  varchar(2) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '�й�' COMMENT '�е�����' AFTER `sbtype`,
MODIFY COLUMN `dangan`  varchar(5) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '����' AFTER `zdtype`,
MODIFY COLUMN `adderss`  varchar(4) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'Ǩ���' AFTER `dangan`,
MODIFY COLUMN `status`  varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '�½��ͻ�' COMMENT '״̬' AFTER `adderss`,
MODIFY COLUMN `service`  varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '�����' AFTER `speed`,
MODIFY COLUMN `shebao`  varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '�籣' AFTER `service`,
MODIFY COLUMN `shebaoname`  varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '�籣��˾' AFTER `shebao`,
MODIFY COLUMN `txadderss`  varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'ͨѶ��ַ' AFTER `shebaoname`,
MODIFY COLUMN `rcdate`  varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '�˲�������ʱ��' AFTER `txadderss`,
MODIFY COLUMN `add_time`  int(10) NULL DEFAULT NULL COMMENT '���ʱ��' AFTER `rcdate`,
MODIFY COLUMN `I_date`  int(11) NULL DEFAULT NULL COMMENT 'һ���¼' AFTER `speed_time`,
MODIFY COLUMN `II_date`  int(11) NULL DEFAULT NULL COMMENT '�����¼' AFTER `I_date`,
MODIFY COLUMN `Tag`  varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL AFTER `II_date`,
ADD COLUMN `pay_mode`  varchar(255) NULL AFTER `deposit`,
ADD COLUMN `nuser_id`  int NULL AFTER `user_id`,
ADD COLUMN `wuser_id`  int NULL AFTER `nuser_id`,
ADD COLUMN `dangan_ads`  varchar(255) NULL AFTER `dangan`,
ADD COLUMN `place`  varchar(255) NULL AFTER `service`,
ADD COLUMN `area`  varchar(255) NULL AFTER `shebaoname`;