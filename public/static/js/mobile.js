function but_ajax_post(url,param){
	var obj = $('#dg').datagrid('getSelected');
    if (!obj){$.messager.alert('警告','未选择任何数据!',"warning");return;}  
	$.messager.confirm('确认','是否修改--['+obj.name+']--为:'+param,function(r){    
		if (r){    
			$.ajax({
			   type: "POST",
			   async: true,
			   dataType: "json",
			   url:  url,
			   data: {card:obj.card, param:param },
			   success: function(data){					
					if (data.code > 1 ) {
						$.messager.alert('服务器消息',data.msg,"info");
						$.mobile.go('#dgpage');
						if ($('#dg_type').val()=='get') {
							$('#dg').datagrid('reload'); 
						}else{
							$('.searchbox-button').trigger("click");
						}	 					
					}else{
						return $.messager.alert('服务器消息',data.msg,"error");
					}	                 
			   }
			});	
		}    
	}); 
}

$(function($){
	//数据表格
    $('#dg').datagrid({    
		url:'/api/gdata/get',    
		striped:true,
		singleSelect:true,
		rownumbers:true,
		pagination:true,
		pageSize:10,
 		rowStyler:function(index,row){
			//大于2天的高亮显示
			if(row.rcdate!=null){
				if(diffTime(row.rcdate) < 1){
				   //console.log(diffTime(row.rcdate));
				   //console.log(row.name);
				   return 'color:blue;';
				}
			}
		},			
		columns:[[    
			{field:'name',title:'姓名',width:"20%"},    
			{field:'tel',title:'电话',width:"30%"},     
			{field:'speed',title:'进度',width:"15%"}, 
			{field:'rcdate',title:'预约时间',width:"35%"}, 
		]],
		onLoadSuccess:function(data){//数据加载成功触发
			//保存上一次请求方法 get or sousou 
			$('#dg_type').val(data.type);
		},		
        //用户双击事件
		onClickRow:function(index, obj){
			$(".imagebox").empty();//清空图片箱子
			$("#t-name").html(obj.name);//填充姓名
			$("#t-education").html(obj.education);
			$("#t-card").html(obj.card);//填充身份证
			$("#t-tel").html(obj.tel);
			$("#t-price").html(obj.price);
			$("#t-deposit").html(obj.deposit);
			$("#t-wangwang").html(obj.wangwang);
			$("#t-renbao_user").html(obj.renbao_user);
			$("#t-renbao_password").html(obj.renbao_password);
			$("#comment").html(obj.comment);
            $("#comm").val(obj.comment);
            //$('#comm').textbox('setText',obj.comment);
            $("#t-speed").html(obj.speed);
			$("#t-speed_time").html(obj.speed_time);
			$("#t-add_time").html(obj.add_time);
			$("#t-user").html(obj.user);
			$("#t-adderss").html(obj.adderss);
			$("#t-mode").html(obj.mode);
			$("#t-child").html(obj.child);
			$("#t-childad").html(obj.childad);
			$("#t-shebao").html(obj.shebao);
			$("#t-marriage").html(obj.marriage);		
			$("#t-service").html(obj.service);	
            $("#t-tel").attr("href","tel:"+obj.tel); 
            $("#t-rcdate").html(obj.rcdate);	
		   $.get("/upimage/getpic.php?card="+obj.card, function(data){
			  var obj2 = $.parseJSON(data);
			  var img2 ="side:'bottom'";
			  for(var i=0;i<obj2.length;i++){
				 var img ="<div><a href='/UpImage/server/"+obj.card+"/"+obj2[i]+"' class='strip' data-strip-group='shared-options' data-strip-group-options="+img2+"><img src='/UpImage/server/"+obj.card+"/"+obj2[i]+"' class='img-polaroid'></a></div>";
			     $(".imagebox").append(img);
			  }
			});
			$.mobile.go('#p2');
		} 
	});
})