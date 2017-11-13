
/**
 * 树形菜单创建
 * @param treeid
 * @param url
 */
function onClickMenu(treeid,url){
    $('#'+treeid).tree({
        url:url,
        onLoadSuccess:function(node, data){
            //console.log(data);
        },
        //0 直接返回  1 json     2 url    3  code    4 Tsb add
        onClick: function(node){
            select_index = null;
            // 0 是不做操作
            if  (node.type == 0 )return;

            // 1 Dg 条件设置
            if (node.type == 1 ) {

                //先判断面板不存在就添加存在就选中
                var isdisply = $('#tabs').tabs('exists',node.title);
                if (!isdisply) {
                    $('#tabs').tabs('add',{
                        title: node.title,
                        selected: true,
                        closable: true,
                        href : node.url,
                        onLoad: function (){

                        }
                    })
                } else {

                    $('#tabs').tabs('select',node.title);//选中

                }

                if (typeof node.json == "string"){

                    node.json = $.parseJSON(node.json);

                }

                // dg 从新加载dg参数   这里通过AJAX 会有问题...估计是加载没完成吧, JS会报错
                //var params = $('#'+node.dgid).datagrid('options').queryParams; //先取得 datagrid 的查询参数
                if(node.json != null || node.json != undefined || node.json != "" ) {
                    var fields = node.json; //JSON.parse(node.json); //json字符串转到对象
                    $('#'+node.dgid).datagrid({
                        queryParams: fields
                    });
                } else {
                    $('#'+node.dgid).datagrid('reload');
                }
                console.log("DG : " + node.dgid );
            }

            // 2 URL ajax 加载 add 到 tabs 选项卡
            if (node.type == 2 ) {
                var isdisply = $('#tabs').tabs('exists',node.text);
                if (!isdisply) {
                    $('#tabs').tabs('add',{
                        title: node.text,
                        selected: true,
                        closable: true,
                        href : node.url
                    })
                } else {
                    $('#tabs').tabs('select',node.text);//选中
                }
            }

            // 3 执行server js 代码
            if (node.type == 3 ) {
                mfun = new Function(node.script)();
            }
        }

    });
}


/**
 * DG按钮打开窗口提交
 * @注意  dg属性是在按钮父级别属性
 * @示列  <a onclick="ButtonRunDialog(this)"  dialog="" load="true|null" URL="del" class="easyui-linkbutton"></a>
 * @param options
 * @constructor
 */
function ButtonRunDialog(options) {
    //提交 URL
    var url = $(options).attr("URL");
    //窗口 标题
    var text = $(options).context.innerText;
    //窗口 容器id
    var diaid = $(options).attr("dialog");
    //按钮方法 edit|add
    var load = $(options).attr("load");
    //DG 内容获取 血的教训. 获取不到DG会出错.
    var dg = $(options).parent().attr("dg");
    if (dg == undefined || dg == null || dg == "") {
       return  alert("未设置 dg 属性");
    }
    if ( load == 'true') {// 这里是字符串
        var row = $('#' + dg).datagrid('getSelected');
        if (row != null) {
            //如果是Data 的编辑就直接用网络数据
            if(url == 'data/Edit'){
                //data 的 edit 需要获取原始数据,修改器的数据是不行的.
                $.getJSON(url+"One/"+row.id,function(row){
                    url = url +'/'+ row.id;
                    _Dialog(diaid, text, {
                        url:url,
                        rows:row,
                        load:load
                    });
                })
            }else { //不是编辑Data数据的话就直接用js数据加载就可以了.
                url = url +'/'+ row.id;
                _Dialog(diaid, text, {
                    url:url,
                    rows:row,
                    load:load
                });
            }
        }else{
            showMsg("错误", '未选取数据!', true, 'error');
        }
    } else {
        _Dialog(diaid,text,{
            url:url,
            rows:null
        });
    }
    console.info("URL:" + url);
}
/**
 * 创建窗口提交窗口如果 row 有数据就加载显示到表单
 *
 * @param id      容器ID
 * @param title   标题
 * @param data     数据存储
 * @private
 */
function _Dialog(id,  title = null, data = null ) {

    $("#" + id + "-form").form('clear');

    if (title != null || title != undefined || title != "" ) {
        $("#" + id).dialog({
            title: title
        });
    }

    $("#" + id).dialog({
        buttons: [{
            text: '提交',
            handler: function(){
                //做了提交处理
                dialogSubmit(id, data.url);
            }
        }, {
            text: '关闭',
            handler: function () {
                $("#" + id).dialog('close');
            }
        }]
    });

    if (data != null) {
        if (data.load == 'true') {
            $('#card').textbox('readonly', true);
        } else {
            $('#card').textbox('readonly', false);
        }
        $("#" + id + "-form").form('load', data.rows);
        //$("#" + id).data('row', row);
    }
    $("#" + id).dialog('open');
}


/**
 * 窗口模式提交表单数据到服务器
 * @示例  <div class="easyui-dialog" dg="value" form="value"><form action="value" ></form></div>
 * @param dialogid  窗口ID
 * @param URL       提交的URL 是NULL的时候自动获取 ACTION 属性
 */
function dialogSubmit(dialogid, url = null) {
    // 取表单ID
    var formid = $('#' + dialogid).attr('form');
    if (formid == undefined || formid == "") {
        return alert('请检查 dialogid 的 form 属性是否存在');
    }

    // 取DGID 刷新用
    var dgid = $('#' + dialogid).attr('dg');
    if (dgid == undefined || dgid == "") {
        return alert('检查dialogid 的 dg 属性是否存在');
    }

    // 取表单提交地址
    if (url == null) {
        var url = $('#' + formid).attr('action');
        if (url == undefined || url == '') {
            return alert('URL出错 查看是否设置form 的 action属性 或者传入url 参数');
        }
    }
    // 序列化表单数据
    var formParam = $('#' + formid).serialize();
    //开始提交任务 带验证表单
    if ( $('#' + formid).form('validate') ) {
        showConfirm("系统", "执行命令是否确认 ? ", function () {
            jsonAjax('post', url, formParam, function (ret) {
                if (ret.code == Success) {
                    showMsg("完成", "成功", false);
                    closeDialog(dialogid);
                    //存在DG属性就刷新
                    if (dgid != undefined || dgid != "") {
                        $('#' + dgid).datagrid('reload');
                    }
                } else {
                    showMsg("错误", ret.msg, true, 'error');
                }
            })
        });
    } else {
        showMsg("错误", '数据验证失败! 请检查数据规则.,', true, 'error');
    }
}


/**
 *  带窗口的表单提交
 * @param dialogid string 窗口ID
 * @param formid string  表单ID
 * @param getrow bool  获取选中行
 * @param action seting URL
 * */
function formSubmit(dialogid, formid, getRow = false, action = false) {
    var url = null;
    //获取dg row
    var row = getRow ? getSingleSelectRow("dg") : null;
    var formParam = $('#' + formid).serialize();
    var key = action ? action : $('#' + formid).attr('action');
    if (config[key] == undefined) config[key] = action;
    if (row != null) {
        url = config[key] + row.Id;
        showConfirm("系统", "执行命令是否确认 ? ", function () {
            jsonAjax('post', url, formParam, function (ret) {
                if (ret.code == Success) {
                    showMsg("完成", "成功", false);
                    closeDialog(dialogid);
                } else {
                    showMsg("错误", ret.msg, true, 'error');
                }
            })
        });
    } else {
        url = config[key];
        //console.log(config);
        jsonAjax('post', url, formParam, function (ret) {
            if (ret.code == Success) {
                showMsg("完成", "提交成功", false);
                closeDialog(dialogid);

            } else {
                showMsg("错误", ret.msg, true, 'error');
            }
        })
    }
    if (url == undefined) {
        alert("URL错误");
        console.info("key:" + key + " action:" + action);
    }
    console.info("URL:" + url);
}


/**
 * 显示带表单的提交窗口
 * @param id       窗口id
 * @param dgid     数据表ID
 * @param funSave  提交回调函
 * @param getrow   是否获取ROW
 */
function showDialog(id, Dgid = null, title = null, funSave = null) {
    if (title != null) {
        $("#" + id).dialog({
            title: title
        });
    }
    if (funSave != null) {
        $("#" + id).dialog({
            buttons: [{
                text: '提交',
                handler: funSave
            }, {
                text: '关闭',
                handler: function () {
                    $("#" + id).dialog('close');
                }
            }]
        });
    }
    if (Dgid != null) {
        var row = getSingleSelectRow(Dgid);
        if (row == null) {
            return;
        } else {
            $("#" + id + "-form").form('load', row);
            $("#" + id).data('row', row);
        }
    }
    $("#" + id).dialog('open');
}


/**
 * 计算指定时间字符串到当前时间的天
 * @param end_str
 * @returns {number}
 */
function diffTime(end_str) {
    //end_str = ("2016-15-02 10:15:00").replace(/-/g,"/");
    //一般得到的时间的格式都是：yyyy-MM-dd hh24:mi:ss，所以我就用了这个做例子，是/的格式，就不用replace了。
    var end_date = new Date(end_str);//已当前时间为结束时间
    //开始时间
    //sta_str = ("2017-07-13 18:53:00").replace(/-/g,"/");
    var sta_date = new Date();
    var num = (end_date - sta_date) / (1000 * 3600 * 24);//求出两个时间的时间差，这个是天数
    return num;
    //var days = parseInt(Math.ceil(num));//转化为整天（小于零的话剧不用转了）
}

function myformatter(date) {
    var y = date.getFullYear();
    var m = date.getMonth() + 1;
    var d = date.getDate();
    return y + '-' + (m < 10 ? ('0' + m) : m) + '-' + (d < 10 ? ('0' + d) : d);
};

function myparser(s) {
    if (!s) return new Date();
    var ss = (s.split('-'));
    var y = parseInt(ss[0], 10);
    var m = parseInt(ss[1], 10);
    var d = parseInt(ss[2], 10);
    if (!isNaN(y) && !isNaN(m) && !isNaN(d)) {
        return new Date(y, m - 1, d);
    } else {
        return new Date();
    }
};

function my2formatter(date) {
    var y = date.getFullYear();
    var m = date.getMonth() + 1;
    var d = date.getDate();
    var h = date.getHours();
    var min = date.getMinutes();
    //var sec = date.getSeconds();

    var str = y + '-' + (m < 10 ? ('0' + m) : m) + '-' + (d < 10 ? ('0' + d) : d) + ' ' + (h < 10 ? ('0' + h) : h) + ':' + (min < 10 ? ('0' + min) : min);//+':'+(sec<10?('0'+sec):sec);
    return str;
};
function my2parser(s) {
    if (!s) return new Date();
    var y = s.substring(0, 4);
    var m = s.substring(5, 7);
    var d = s.substring(8, 10);
    var h = s.substring(11, 13);
    var min = s.substring(14, 16);
    //2017-08-07 14:00
    //console.log(min);
    //var sec = s.substring(18,20);
    if (!isNaN(y) && !isNaN(m) && !isNaN(d) && !isNaN(h) && !isNaN(min)) {
        return new Date(y, m - 1, d, h, min);
    } else {
        return new Date();
    }
};

/**
 *  序列化表单数据
 * @param frm
 * @returns {{}}
 */
function getFormJson(frm) {
    var o = {};
    var a = $(frm).serializeArray();
    $.each(a, function () {
        if (o[this.name] !== undefined) {
            if (!o[this.name].push) {
                o[this.name] = [o[this.name]];
            }
            o[this.name].push(this.value || '');
        } else {
            o[this.name] = this.value || '';
        }
    });
    return o;
}
/**
 *  Ajax POST       提交
 * @param url       url地址
 * @param data      数据
 * @param confirm   是否显示对话框
 * @constructor
 */
function AjaxPost(url, data, confirm = true) {
    var res;
    if (confirm) {
        showConfirm("您好", "是否确认 ? ", function () {
            jsonAjax('post', url, data, function (ret) {
                if (ret.code == Success) {
                    showMsg("完成", ret.msg, true);
                    res = true;
                } else {
                    showMsg("错误", ret.msg, true, "error");
                    res = false;
                }
            })
        });
    } else {
        jsonAjax('post', url, data, function (ret) {
            if (ret.code == Success) {
                showMsg("完成", ret.msg, true);
                res = true;
            } else {
                showMsg("错误", ret.msg, true, "error");
                res = false;
            }
        })
    }
    return res;
}
/**
 * ajax post提交
 * @param url
 * @param param
 * @param datat 为html,json,text
 * @param callback回调函数
 * @return
 */
function jsonAjax(type, url, param, callback) {
    $.ajax({
        type: type,
        async: true,
        url: url,
        data: param,
        dataType: 'json',
        success: callback,
        error: function () {

        }
    });
}
//confirm
function Confirm(msg, control) {
    $.messager.confirm('确认', msg, function (r) {
        if (r) {
            eval(control.toString().slice(11));
        }
    });
    return false;
}
//load
function Load() {
    $("<div class=\"datagrid-mask\"></div>").css({
        display: "block",
        width: "100%",
        height: $(window).height()
    }).appendTo("body");
    $("<div class=\"datagrid-mask-msg\"></div>").html("正在运行，请稍候。。。").appendTo("body").css({
        display: "block",
        left: ($(document.body).outerWidth(true) - 190) / 2,
        top: ($(window).height() - 45) / 2
    });
}
//display Load
function dispalyLoad() {
    $(".datagrid-mask").remove();
    $(".datagrid-mask-msg").remove();
}
//弹出提醒框alert
function showMsg(title, msg, isAlert, icon="info") {
    if (isAlert !== undefined && isAlert) {
        $.messager.alert(title, msg, icon);
    } else {
        $.messager.show({
            title: title,
            msg: msg,
            showType: 'show'
        });
    }
}

//删除确认confirm
function deleteConfirm() {
    return showConfirm('温馨提示', '确定要删除吗?');
}

//弹出确认框confirm
function showConfirm(title, msg, callback) {
    $.messager.confirm(title, msg, function (r) {
        if (r) {
            if (jQuery.isFunction(callback))
                callback.call();
        }
    });
}

//进度条
function showProcess(isShow, title, msg) {
    if (!isShow) {
        $.messager.progress('close');
        return;
    }
    var win = $.messager.progress({
        title: title,
        msg: msg
    });
}

//弹出框体window
function showMyWindow(title, href, width, height, modal, minimizable, maximizable) {

    $('#myWindow').window({

        title: title,

        width: width === undefined ? 600 : width,

        height: height === undefined ? 400 : height,

        content: '<iframe scrolling="yes" frameborder="0"  src="' + href + '" style="width:100%;height:98%;"></iframe>',

        //        href: href === undefined ? null : href,

        modal: modal === undefined ? true : modal,

        minimizable: minimizable === undefined ? false : minimizable,

        maximizable: maximizable === undefined ? false : maximizable,

        shadow: false,

        cache: false,

        closed: false,

        collapsible: false,

        resizable: false,

        loadingMessage: '正在加载数据，请稍等片刻......'

    });

}

//关闭弹出框体 window
function closeMyWindow() {

    $('#myWindow').window('close');

}

/**
 *清空指定表单中的内容,参数为目标form的id
 *注：在使用Jquery EasyUI的弹出窗口录入新增内容时，每次打开必须清空上次输入的历史
 *数据，此时通常采用的方法是对每个输入组件进行置空操作:$("#name").val(""),这样做，
 *当输入组件比较多时会很繁琐，产生的js代码很长，这时可以将所有的输入组件放入个form表单
 *中，然后调用以下方法即可。
 *
 *@param formId将要清空内容的form表单的id
 */
function resetContent(formId) {
    var clearForm = document.getElementById(formId);
    if (null != clearForm && typeof (clearForm) != "undefined") {
        clearForm.reset();
    }
}

/**
 *刷新DataGrid列表(适用于Jquery Easy Ui中的dataGrid)
 *注：建议采用此方法来刷新DataGrid列表数据(也即重新加载数据)，不建议直接使用语句
 *$('#dataTableId').datagrid('reload');来刷新列表数据，因为采用后者，如果日后
 *在修改项目时，要在系统中的所有刷新处进行其他一些操作，那么你将要修改系统中所有涉及刷新
 *的代码，这个工作量非常大，而且容易遗漏；但是如果使用本方法来刷新列表，那么对于这种修
 *该需求将很容易做到，而去不会出错，不遗漏。
 *
 *@paramdataTableId将要刷新数据的DataGrid依赖的table列表id
 */
function flashTable(dataTableId) {
    $('#' + dataTableId).datagrid('reload');
}
/**
 *取消DataGrid中的行选择(适用于Jquery Easy Ui中的dataGrid)
 *注意：解决了无法取消"全选checkbox"的选择,不过，前提是必须将列表展示
 *数据的DataGrid所依赖的Table放入html文档的最全面，至少该table前没有
 *其他checkbox组件。
 *
 *@paramdataTableId将要取消所选数据记录的目标table列表id
 */
function clearSelect(dataTableId) {
    $('#' + dataTableId).datagrid('clearSelections');
    //取消选择DataGrid中的全选
    $("input[type='checkbox']").eq(0).attr("checked", false);
}

/**
 *关闭Jquery EasyUi的弹出窗口(适用于Jquery Easy Ui)
 *
 *@paramdialogId将要关闭窗口的id
 */
function closeDialog(dialogId) {
    $('#' + dialogId).dialog('close');
}

/**
 *自适应表格的宽度处理(适用于Jquery Easy Ui中的dataGrid的列宽),
 *注：可以实现列表的各列宽度跟着浏览宽度的变化而变化，即采用该方法来设置DataGrid
 *的列宽可以在不同分辨率的浏览器下自动伸缩从而满足不同分辨率浏览器的要求
 *使用方法：(如:{field:'ymName',title:'编号',width:fillsize(0.08),align:'center'},)
 *
 *@parampercent当前列的列宽所占整个窗口宽度的百分比(以小数形式出现，如0.3代表30%)
 *
 *@return通过当前窗口和对应的百分比计算出来的具体宽度
 */
function fillsize(percent) {
    var bodyWidth = document.body.clientWidth;
    return (bodyWidth - 90) * percent;
}

/**
 * 获取所选记录行(单选)
 *
 * @paramdataTableId目标记录所在的DataGrid列表的table的id
 * @paramerrorMessage 如果没有选择一行(即没有选择或选择了多行)的提示信息
 *
 * @return 所选记录行对象，如果返回值为null,或者"null"(有时浏览器将null转换成了字符串"null")说明没有
 *选择一行记录。
 */
function getSingleSelectRow(dataTableId, ico="info") {
    var rows = $('#' + dataTableId).datagrid('getSelections');
    var num = rows.length;
    if (num == 1) {
        return rows[0];
    } else {
        $.messager.alert('错误', "你至少要选择一条数据吧!", 'error');
        return null;
    }
}

/**
 * 在DataGrid中获取所选记录的id,多个id用逗号分隔
 * 注：该方法使用的前提是：DataGrid的idField属性对应到列表Json数据中的字段名必须为id
 * @paramdataTableId目标记录所在的DataGrid列表table的id
 *
 * @return 所选记录的id字符串(多个id用逗号隔开)
 */
function getSelectIds(dataTableId, noOneSelectMessage) {
    var rows = $('#' + dataTableId).datagrid('getSelections');
    var num = rows.length;
    var ids = null;
    if (num < 1) {
        if (null != noOneSelectMessage) $.messager.alert('提示消息', noOneSelectMessage, 'info');
        return null;
    } else {
        for (var i = 0; i < num; i++) {
            if (null == ids || i == 0) {
                ids = rows[i].id;
            } else {
                ids = ids + "," + rows[i].id;
            }
        }
        return ids;
    }
}

/**
 *删除所选记录(适用于Jquery Easy Ui中的dataGrid)(删除的依据字段是id)
 *注：该方法会自动将所选记录的id(DataGrid的idField属性对应到列表Json数据中的字段名必须为id)
 *动态组装成字符串，多个id使用逗号隔开(如：1,2,3,8,10)，然后存放入变量ids中传入后台，后台
 *可以使用该参数名从request对象中获取所有id值字符串，此时在组装sql或者hql语句时可以采用in
 *关键字来处理，简介方便。
 *另外，后台代码必须在操作完之后以ajax的形式返回Json格式的提示信息，提示的json格式信息中必须有一个
 *message字段，存放本次删除操作成功与失败等一些提示操作用户的信息。
 *
 *@paramdataTableId将要删除记录所在的列表table的id
 *@paramrequestURL与后台服务器进行交互，进行具体删除操作的请求路径
 *@paramconfirmMessage 删除确认信息
 */

function deleteNoteById(dataTableId, requestURL, confirmMessage) {
    if (null == confirmMessage || typeof (confirmMessage) == "undefined" || "" == confirmMessage) {
        confirmMessage = "确定删除所选记录?";
    }
    var rows = $('#' + dataTableId).datagrid('getSelections');
    var num = rows.length;
    var ids = null;
    if (num < 1) {
        $.messager.alert('提示消息', '请选择你要删除的记录!', 'info');
    } else {
        $.messager.confirm('确认', confirmMessage, function (r) {
            if (r) {
                for (var i = 0; i < num; i++) {
                    if (null == ids || i == 0) {
                        ids = rows[i].id;
                    } else {
                        ids = ids + "," + rows[i].id;
                    }
                }
                $.getJSON(requestURL, {"ids": ids}, function (data) {
                    if (null != data && null != data.message && "" != data.message) {
                        $.messager.alert('提示消息', data.message, 'info');
                        flashTable(dataTableId);
                    } else {
                        $.messager.alert('提示消息', '删除失败！', 'warning');
                    }
                    clearSelect(dataTableId);
                });
            }
        });
    }
}

