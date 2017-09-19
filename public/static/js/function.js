//����ָ��ʱ���ַ�������ǰʱ�����
function diffTime(end_str) {  
	//end_str = ("2016-15-02 10:15:00").replace(/-/g,"/");
	//һ��õ���ʱ��ĸ�ʽ���ǣ�yyyy-MM-dd hh24:mi:ss�������Ҿ�������������ӣ���/�ĸ�ʽ���Ͳ���replace�ˡ�  
	var end_date = new Date(end_str);//�ѵ�ǰʱ��Ϊ����ʱ��  
	//��ʼʱ��  
	//sta_str = ("2017-07-13 18:53:00").replace(/-/g,"/");  
	var sta_date = new Date();  
	var num = (end_date-sta_date)/(1000*3600*24);//�������ʱ���ʱ�����������  
    return num;
	//var days = parseInt(Math.ceil(num));//ת��Ϊ���죨С����Ļ��粻��ת�ˣ�  
}
function myformatter(date){
    var y = date.getFullYear();
    var m = date.getMonth()+1;
    var d = date.getDate();
    return y+'-'+(m<10?('0'+m):m)+'-'+(d<10?('0'+d):d);
};

function myparser(s){
    if (!s) return new Date();
    var ss = (s.split('-'));
    var y = parseInt(ss[0],10);
    var m = parseInt(ss[1],10);
    var d = parseInt(ss[2],10);
    if (!isNaN(y) && !isNaN(m) && !isNaN(d)){
        return new Date(y,m-1,d);
    } else {
        return new Date();
    }
};


/**  
* ajax post�ύ  
* @param url  
* @param param  
* @param datat Ϊhtml,json,text  
* @param callback�ص�����  
* @return  
*/  
function jsonAjax(url, param, callback) {  
	$.ajax({  
		type: "post",  
		url: url,  
		data: param,  
		dataType: 'json',  
		success: callback,  
		error: function () {  
			jQuery.fn.mBox({  
				message: '�ָ�ʧ��'  
			});  
		}  
	});  
}  
//confirm   
function Confirm(msg, control) {  
    $.messager.confirm('ȷ��', msg, function (r) {  
        if (r) {  
            eval(control.toString().slice(11));  
        }  
    });  
    return false;  
}  
//load  
function Load() {  
    $("<div class=\"datagrid-mask\"></div>").css({ display: "block", width: "100%", height: $(window).height() }).appendTo("body");  
    $("<div class=\"datagrid-mask-msg\"></div>").html("�������У����Ժ򡣡���").appendTo("body").css({ display: "block", left: ($(document.body).outerWidth(true) - 190) / 2, top: ($(window).height() - 45) / 2 });  
}  
//display Load  
function dispalyLoad() {  
    $(".datagrid-mask").remove();  
    $(".datagrid-mask-msg").remove();  
}  
//�������ѿ�alert  
function showMsg(title, msg, isAlert) {  
    if (isAlert !== undefined && isAlert) {  
        $.messager.alert(title, msg);  
    } else {  
        $.messager.show({  
            title: title,  
            msg: msg,  
            showType: 'show'  
        });  
    }  
}  
  
//ɾ��ȷ��confirm  
function deleteConfirm() {  
    return showConfirm('��ܰ��ʾ', 'ȷ��Ҫɾ����?');  
}  
  
//����ȷ�Ͽ�confirm  
function showConfirm(title, msg, callback) {  
    $.messager.confirm(title, msg, function (r) {  
        if (r) {  
            if (jQuery.isFunction(callback))  
                callback.call();  
        }  
    });  
}  
  
//������  
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
  
//��������window  
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
  
        loadingMessage: '���ڼ������ݣ����Ե�Ƭ��......'  
  
    });  
  
}  
  
//�رյ������� window  
function closeMyWindow() {  
  
    $('#myWindow').window('close');  
  
}  
  
/** 
*���ָ�����е�����,����ΪĿ��form��id 
*ע����ʹ��Jquery EasyUI�ĵ�������¼����������ʱ��ÿ�δ򿪱�������ϴ��������ʷ 
*���ݣ���ʱͨ�����õķ����Ƕ�ÿ��������������ÿղ���:$("#name").val(""),�������� 
*����������Ƚ϶�ʱ��ܷ�����������js����ܳ�����ʱ���Խ����е�������������form�� 
*�У�Ȼ��������·������ɡ� 
* 
*@param formId��Ҫ������ݵ�form����id 
*/  
function resetContent(formId) {  
    var clearForm = document.getElementById(formId);  
    if (null != clearForm && typeof (clearForm) != "undefined") {  
        clearForm.reset();  
    }  
}  
  
/** 
*ˢ��DataGrid�б�(������Jquery Easy Ui�е�dataGrid) 
*ע��������ô˷�����ˢ��DataGrid�б�����(Ҳ�����¼�������)��������ֱ��ʹ����� 
*$('#dataTableId').datagrid('reload');��ˢ���б����ݣ���Ϊ���ú��ߣ�����պ� 
*���޸���Ŀʱ��Ҫ��ϵͳ�е�����ˢ�´���������һЩ��������ô�㽫Ҫ�޸�ϵͳ�������漰ˢ�� 
*�Ĵ��룬����������ǳ��󣬶���������©���������ʹ�ñ�������ˢ���б���ô���������� 
*�����󽫺�������������ȥ�����������©�� 
* 
*@paramdataTableId��Ҫˢ�����ݵ�DataGrid������table�б�id 
*/  
function flashTable(dataTableId) {  
    $('#' + dataTableId).datagrid('reload');  
}  
/** 
*ȡ��DataGrid�е���ѡ��(������Jquery Easy Ui�е�dataGrid) 
*ע�⣺������޷�ȡ��"ȫѡcheckbox"��ѡ��,������ǰ���Ǳ��뽫�б�չʾ 
*���ݵ�DataGrid��������Table����html�ĵ�����ȫ�棬���ٸ�tableǰû�� 
*����checkbox����� 
* 
*@paramdataTableId��Ҫȡ����ѡ���ݼ�¼��Ŀ��table�б�id 
*/  
function clearSelect(dataTableId) {  
    $('#' + dataTableId).datagrid('clearSelections');  
    //ȡ��ѡ��DataGrid�е�ȫѡ  
    $("input[type='checkbox']").eq(0).attr("checked", false);  
}  
  
/** 
*�ر�Jquery EasyUi�ĵ�������(������Jquery Easy Ui) 
* 
*@paramdialogId��Ҫ�رմ��ڵ�id 
*/  
function closeDialog(dialogId) {  
    $('#' + dialogId).dialog('close');  
}  
  
/** 
*����Ӧ���Ŀ�ȴ���(������Jquery Easy Ui�е�dataGrid���п�), 
*ע������ʵ���б�ĸ��п�ȸ��������ȵı仯���仯�������ø÷���������DataGrid 
*���п�����ڲ�ͬ�ֱ��ʵ���������Զ������Ӷ����㲻ͬ�ֱ����������Ҫ�� 
*ʹ�÷�����(��:{field:'ymName',title:'���',width:fillsize(0.08),align:'center'},) 
* 
*@parampercent��ǰ�е��п���ռ�������ڿ�ȵİٷֱ�(��С����ʽ���֣���0.3����30%) 
* 
*@returnͨ����ǰ���ںͶ�Ӧ�İٷֱȼ�������ľ����� 
*/  
function fillsize(percent) {  
    var bodyWidth = document.body.clientWidth;  
    return (bodyWidth - 90) * percent;  
}  
  
/** 
* ��ȡ��ѡ��¼��(��ѡ) 
* 
* @paramdataTableIdĿ���¼���ڵ�DataGrid�б��table��id 
* @paramerrorMessage ���û��ѡ��һ��(��û��ѡ���ѡ���˶���)����ʾ��Ϣ 
* 
* @return ��ѡ��¼�ж����������ֵΪnull,����"null"(��ʱ�������nullת�������ַ���"null")˵��û�� 
*ѡ��һ�м�¼�� 
*/  
function getSingleSelectRow(dataTableId, errorMessage) {  
    var rows = $('#' + dataTableId).datagrid('getSelections');  
    var num = rows.length;  
    if (num == 1) {  
        return rows[0];  
    } else {  
        $.messager.alert('��ʾ��Ϣ', errorMessage, 'info');  
        return null;  
    }  
}  
  
/** 
* ��DataGrid�л�ȡ��ѡ��¼��id,���id�ö��ŷָ� 
* ע���÷���ʹ�õ�ǰ���ǣ�DataGrid��idField���Զ�Ӧ���б�Json�����е��ֶ�������Ϊid 
* @paramdataTableIdĿ���¼���ڵ�DataGrid�б�table��id 
* 
* @return ��ѡ��¼��id�ַ���(���id�ö��Ÿ���) 
*/  
function getSelectIds(dataTableId, noOneSelectMessage) {  
    var rows = $('#' + dataTableId).datagrid('getSelections');  
    var num = rows.length;  
    var ids = null;  
    if (num < 1) {  
        if (null != noOneSelectMessage) $.messager.alert('��ʾ��Ϣ', noOneSelectMessage, 'info');  
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
*ɾ����ѡ��¼(������Jquery Easy Ui�е�dataGrid)(ɾ���������ֶ���id) 
*ע���÷������Զ�����ѡ��¼��id(DataGrid��idField���Զ�Ӧ���б�Json�����е��ֶ�������Ϊid) 
*��̬��װ���ַ��������idʹ�ö��Ÿ���(�磺1,2,3,8,10)��Ȼ���������ids�д����̨����̨ 
*����ʹ�øò�������request�����л�ȡ����idֵ�ַ�������ʱ����װsql����hql���ʱ���Բ���in 
*�ؼ�����������鷽�㡣 
*���⣬��̨��������ڲ�����֮����ajax����ʽ����Json��ʽ����ʾ��Ϣ����ʾ��json��ʽ��Ϣ�б�����һ�� 
*message�ֶΣ���ű���ɾ�������ɹ���ʧ�ܵ�һЩ��ʾ�����û�����Ϣ�� 
* 
*@paramdataTableId��Ҫɾ����¼���ڵ��б�table��id 
*@paramrequestURL���̨���������н��������о���ɾ������������·�� 
*@paramconfirmMessage ɾ��ȷ����Ϣ 
*/  
  
function deleteNoteById(dataTableId, requestURL, confirmMessage) {  
    if (null == confirmMessage || typeof (confirmMessage) == "undefined" || "" == confirmMessage) {  
        confirmMessage = "ȷ��ɾ����ѡ��¼?";  
    }  
    var rows = $('#' + dataTableId).datagrid('getSelections');  
    var num = rows.length;  
    var ids = null;  
    if (num < 1) {  
        $.messager.alert('��ʾ��Ϣ', '��ѡ����Ҫɾ���ļ�¼!', 'info');  
    } else {  
        $.messager.confirm('ȷ��', confirmMessage, function (r) {  
            if (r) {  
                for (var i = 0; i < num; i++) {  
                    if (null == ids || i == 0) {  
                        ids = rows[i].id;  
                    } else {  
                        ids = ids + "," + rows[i].id;  
                    }  
                }  
                $.getJSON(requestURL, { "ids": ids }, function (data) {  
                    if (null != data && null != data.message && "" != data.message) {  
                        $.messager.alert('��ʾ��Ϣ', data.message, 'info');  
                        flashTable(dataTableId);  
                    } else {  
                        $.messager.alert('��ʾ��Ϣ', 'ɾ��ʧ�ܣ�', 'warning');  
                    }  
                    clearSelect(dataTableId);  
                });  
            }  
        });  
    }  
} 

 