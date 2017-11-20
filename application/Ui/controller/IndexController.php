<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/18
 * Time: 0:34
 */
namespace app\ui\controller;

use app\api\model\AuthUserHtml;
use app\api\model\Data;
use think\Controller;
use app\api\model\MenuTree;
use app\common\controller\Base;
use app\api\model\User;
use PHPExcel_IOFactory;
use PHPExcel;

class IndexController extends Base
{
    public function index(User $user)
    {
        $buttions  = AuthUserHtml::getByHtmls($this->group_id,'buttions');
        $extadds   = AuthUserHtml::getByHtmls($this->group_id,'adds');
        $filter    = AuthUserHtml::getByHtmls($this->group_id,'filter');
        $user_info = $user->info($this->uid);
        $this->assign('info',$user_info);
        $this->assign('uid',$this->uid);
        $this->assign('buttions',$buttions);
        $this->assign('extadds',$extadds);
        $this->assign('filter',$filter);
        return $this->fetch('/PC/main');
    }

    public function Settings()
    {
        return response($this->fetch("/PC/Ajax/settings"));
    }

    public function Log()
    {
        return response($this->fetch("/PC/Ajax/log"));
    }

    public function Task()
    {
        return response($this->fetch('/PC/Ajax/task'));
    }

    public function Mobile()
    {
        return response($this->fetch('/Mobile/main'));
    }

    public function Upload()
    {
        //$this->assign('idcard');
        return response($this->fetch('/PC/Ajax/upload'));
    }
    public function evidence()
    {
        //$this->assign('idcard');
        return response($this->fetch('/PC/Ajax/evidence'));
    }
    public function downExcel(Data $M)
    {
        $fieids = $this->request->except(['/ui/downExcel'], 'get');
        $params = ['sort' => 'id', 'order' => 'asc'];

        $title = ['编号', '添加时间', '姓名', '标签', '身份证'];
        $fieidstr = 'id,add_time,name,tag,card,sbtype,tel,shebao,shebaoname,adderss,renbao_user,renbao_password,mode,speed,status,service,shop,price,deposit,price-deposit col,I_date,II_date,speed_time,comment';


        $lists = $M->search($params, $fieids, $this->group_id, true, $fieidstr);
        $letter = array('A', 'B', 'C', 'D', 'E', 'F', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U',
            'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG'
        );
        $path = dirname(__FILE__); //找到当前脚本所在路径
        $PHPExcel = new PHPExcel(); //实例化PHPExcel类，类似于在桌面上新建一个Excel表格
        $PHPExcel->getActiveSheet()->setTitle('demo');
        foreach ($title as $key => $tv) {
            $PHPExcel->getActiveSheet()->setCellValue($letter[$key] . '1', $tv);
        }
        //dump($lists);
        //以下就是对处理Excel里的数据，横着放数据
        foreach ($lists as $i => $list) {
            // i 是行 key 是 列
            $itms = array_values($list->toArray());
            $row = $i + 2;
            foreach ($itms as $key => $itm) {
                $PHPExcel->getActiveSheet()->setCellValue($letter[$key] . $row, $itm);
                $PHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);//自动宽度
                //设置边框
                //$PHPExcel->getActiveSheet()->getStyle($letter[$key] . $row)->getBorders()->getTop()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);
                //$PHPExcel->getActiveSheet()->getStyle($letter[$key] . $row)->getBorders()->getLeft()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);
            }
        }
        $PHPWriter = PHPExcel_IOFactory::createWriter($PHPExcel, 'Excel2007');//按照指定格式生成Excel文件，‘Excel2007’表示生成2007版本的xlsx，‘Excel5’表示生成2003版本Excel文件
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');//告诉浏览器输出07Excel文件
        //header('Content-Type:application/vnd.ms-excel');//告诉浏览器将要输出Excel03版本文件
        header('Content-Disposition: attachment;filename='.date("Y-m-d H:i").'.xlsx');//告诉浏览器输出浏览器名称
        header('Cache-Control: max-age=0');//禁止缓存
        $PHPWriter->save("php://output");
    }
}