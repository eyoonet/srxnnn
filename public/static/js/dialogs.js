
function add(){
	$("#add").dialog("open");//弹出窗口
	$('#add-form').form('clear');//清空表单
	$('#card').textbox('readonly',false);
	$('#add').form({url:'/api/gdata/add'});//设置提交地址
};



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
	/*Clss UI*/
	  //窗口
	$('#add').dialog({
		title: '客户资料采集',    
		width: 670,
		height: 'auto',    
		closed: true,    
		cache: false,      
		modal: false,
        buttons:"#add-buttons",
	});   
	  //保存按钮
	$('#add-buttons-save').linkbutton({
		onClick:function(){	
			$.messager.confirm('确认','仔细检查无误后点击确定！',function(r){    
			    if (r){    
			       $('#form_user_data').submit();
			    }    
			});  			
		}
	})
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