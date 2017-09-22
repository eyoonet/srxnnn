function showDataAdd( form =  $('#add-form') ){
    $("#add").dialog("open").dialog('setTitle','Add Data');;//弹出窗口
    form.attr('action','create');
    form.form('clear');//清空表单
    $('#card').textbox('readonly',false);
}
function showDataEdit( form = $('#add-form') ){
    var row = getSingleSelectRow("dg");
    if (row != null ){
        form.attr('action','edit');
        $("#add").dialog("open").dialog('setTitle','Edit Data');;//弹出窗口
        form.form('clear');//清空表单
        form.form('load',row);
        $('#card').textbox('readonly',true);
    }
};
function saveData( form = $('#add-form') ){
    var action = form.attr('action');
    var getRow = (action == "edit") ? true: false ;
    console.log(getRow);
    if(form.form('validate') ){
        formSubmit("add","add-form",getRow,action)
    }
}
//#dg
$(function($){
	//表单验证
 	$.extend($.fn.validatebox.defaults.rules, {    
	    validcard: {    
	        validator: function(value, param){    
	            return /^\d{15}(\d{2}[A-Za-z0-9])?$/i.test(value);   
	        },    
	        message: '我在看着你,敢乱输身份证小心我打你哦!!!'   
	    }    
	}); 


	  //关闭按钮
	$('#add-buttons-close').linkbutton({
		onClick:function(){
			$("#add").dialog("close");
		}
	})
	  //图片上传按钮
	$('#add-buttons-imageup').linkbutton({
		onClick: function(){
			var card = $("#card").val();
			if (card == ""){
				alert('SB啊!身份证是填了在来上传');
			}else{		 
 				 $('#dd_image').html("<iframe src='/upimage?card="+card+"'  width='100%' height='500px'></iframe>");
 				 $('#dd_image').window('open');;
			}
		},
	});  
	  //清空图片按钮
	$('#add-buttons-imagedel').linkbutton({
		onClick: function(){
			alert("图片清空按钮事件");
		},
	}); 	  

	//数据采集表单提交
	$('#add-form').form({
	    onSubmit: function(){ 
	        return $(this).form('validate');   
	    },    
	    success:function(data){    
	       var obj = $.parseJSON(data);
	       if (obj.code > 0) {
	       		$.messager.alert('服务器消息',obj.msg,"info"); 
	       		$("#add").dialog("close");
	       }else{
	      	 	$.messager.alert('服务器消息',obj.msg,"error");
	      	 	return;
	       }
	       //判断上次请求方法来处理 get or sousou
	       if ($('#dg_type').val()=='get') {
	       	   $('#dg').datagrid('reload'); 
	       }else{
	       	   $('.searchbox-button').trigger("click");
	       }
	    }    
	});  
})