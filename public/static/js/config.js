/**
 * Created by Administrator on 2017/9/20.
 */
config = {};
//获取
config.GetData = "/query";
//创建
config.create  = "/create";
//修改
config.edit = "/edit/id/";
//保存
config.save = "/save";
//社保
config.shebao = "/shebao/id/";
//签协议
config.sign = "/sign/id/";
//申报人社
config.submit = "/submit/id/";
//删除
config.del ="/delete/id/";
//待录人保
config.etcinput = "/etcinput/id/"
//退款
config.refund = "/refund/id/";
//后退
config.back = "/back/id/";
//备注
config.comment = "/comment/id/";
//标记
config.tag = "/tag/id/";
//提交
config.commit = "/commit/id/";
//已约号
config.rcyuehao = "/rcyuehao/id/";
//文件审查
config.fileCheck = "/filecheck/id/";
//可以二审
config.soreSubmit = "/soresubmit/id/";
//拿调令
config.takeDiaol  = "/takediaol/id/";
//完结
config.success = "/success/id/";
//派单
config.task = "/task/";
//爽约
config.miss = "/miss/id/";
//问题打回
config.error = "/error/id/";
//备注
config.comment = "/comment/id/";

/**
 * 菜单编辑URL配置
 * @type {string}
 */
//编辑菜单
config.editmenu = "/menu/edit/id/";
//添加菜单
config.addmenu = "/menu/create";
//删除菜单
config.delmenu = "/menu/delete/id/";
/**
 *  静态变量
 * @type {number}
 */
//静态变量
const Success = 200;
const Error   = 400;
//{"code":"0","message:"信息","data":{}}
var obj = {};
obj.row = null;