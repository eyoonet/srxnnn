
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
	  //图片上传按钮
	$('#add-buttons-imageup').linkbutton({
		onClick: function(){
			var card = $("#card").val();
			if (card == ""){
				return showMsg("错误", '身份证有误不能上传!', true, 'error');
			}else{
 				// $('#upLoadByImage').html("<iframe id='imagesfra' src='/ui/upload?card="+card+"'  width='98%' height='500px'></iframe>");
				$('#upLoadByImage').dialog('open');
			}
		},
	});
	  //清空图片按钮
	$('#add-buttons-imagedel').linkbutton({
		onClick: function(){
			alert("图片清空按钮事件");
		},
	});
})