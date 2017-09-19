var select_index;

function updata(obj){
 	//进度修改		
	$('#form_user_data').form('load',obj);//加载表单数据
	$('#card').textbox('readonly',true);
	//$("#card").attr("readonly","readonly");//设置只读   
	$('#form_user_data').form({url:'/api/gdata/updata'});//设置提交地址
	$("#add_user_data_ui").dialog("open");	
}

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
					if ($('#dg_type').val()=='get') {
						$('#dg').datagrid('reload'); 
					}else{
					   $('.searchbox-button').trigger("click");
					}						
					if (data.code > 1 ) {
						$.messager.alert('服务器消息',data.msg,"info");
					}else{
						$.messager.alert('服务器消息',data.msg,"error");
					}	
			   }
			});	
		}    
	}); 
}



$(function($){
	
	
	var toolbar = [{
		text:'添加',
		iconCls:'icon-add',
		handler:function(){add();}
	},{
		text:'编辑',
		iconCls:'icon-edit',
		handler:function(){
		  var obj = $('#dg').datagrid('getSelected');
		  if (!obj) {
		  	$.messager.alert('警告','未选择任何数据!',"warning");
		  }else{
		  	updata(obj);
		  }
		}
	},{
		text:'退款',
		iconCls:'icon-remove',
		handler:function(){
			but_ajax_post('/api/gdata/setorder','退款');
		}
	},{
   		text:'退回',
		iconCls:'icon-undo',
		handler:function(){
			but_ajax_post('/api/gdata/back','退回');//set_status('退回')		
		}
	},{
   		text:'没有社保',
		iconCls:'icon-man',
		handler:function(){
			but_ajax_post('/api/gdata/setstatus','没有社保');//set_status('没有社保')		
		}
	},{
   		text:'问题打回',
		iconCls:'icon-man',
		handler:function(){
			but_ajax_post('/api/gdata/setstatus','问题打回');//set_status('问题打回')		
		}
	},{
   		text:'待录人保',
		iconCls:'icon-man',
		handler:function(){
			but_ajax_post('/api/gdata/setstatus','待录人保');//set_status('待录人保')		
		}
	},{
   		text:'提交人保',
		iconCls:'icon-man',
		handler:function(){
			but_ajax_post('/api/gdata/setstatus','提交人保');//set_status('提交人保')		
		}
	},{
   		text:'已约号',
		iconCls:'icon-man',
		handler:function(){
			but_ajax_post('/api/gdata/setstatus','已约号');//set_status('已约号')		
		}
	},{
   		text:'一审',
		iconCls:'icon-tip',
		handler:function(){
			//but_ajax_post('/api/gdata/setspeed','一审');//set_speed('一审')		
		    but_ajax_post('/api/gdata/nyishen','一审');
		}
	},{
   		text:'已审核',
		iconCls:'icon-tip',
		handler:function(){
			but_ajax_post('/api/gdata/setReview','审核');//set_speed('一审')		
		}
	},{
   		text:'可以二审',
		iconCls:'icon-man',
		handler:function(){
			but_ajax_post('/api/gdata/setstatus','可以二审');//set_status('可以二审')		
		}
	},{
   		text:'二审',
		iconCls:'icon-tip',
		handler:function(){
			but_ajax_post('/api/gdata/setspeed','二审');//set_speed('二审')		
		}
	},{
   		text:'已拿调令',
		iconCls:'icon-man',
		handler:function(){
			but_ajax_post('/api/gdata/setstatus','已拿调令');//set_status('已拿调令')		
		}
	},{
   		text:'完结',
		iconCls:'icon-tip',
		handler:function(){
			but_ajax_post('/api/gdata/orderEnd','完结');//set_speed('完结')		
		}
	},{
   		text:'爽约',
		iconCls:'icon-tip',
		handler:function(){
			but_ajax_post('/api/gdata/emptyyuehao','爽约');//s
		}
	},{
   		text:'派单',
		iconCls:'icon-tip',
		handler:function(){
			pai_show();//but_ajax_post('/api/gdata/emptyyuehao','爽约');//s
		}
	}];

	
	
	$('#dg').datagrid({    
		url:'/api/gdata/get',    
		striped:true,
		singleSelect:true,
		rownumbers:true,
		pagination:true,
		pageSize:15,
		pageList:[15,30,45,60,75],
		toolbar:"#dgtoobar",
		fitColumns:true,
		columns:[[    
			{field:'name',title:'姓名',width:"5%"},
			{field:'card',title:'身份证号',width:'11%'},
			{field:'tel',title:'电话',width:'7%'},
			{field:'mode',title:'入户方式',align:'center',width:'6%'},
			{field:'status',title:'工作流',width:'7%'},
			{field:'education',title:'学历',width:'3%'},
			{field:'shebao',title:'社保',align:'center',width:'4%'},
		    {field:'service',title:'窗口',width:'5%'},
		    {field:'marriage',title:'婚姻',align:'center',width:'4%'},
		    {field:'speed',title:'进度',align:'center',width:'4%'},
			{field:'user',title:'业务员',width:'5%'},
			{field:'add_time',title:'添加时间',width:'7%'},
			{field:'dangan',title:'调档',width:'3%',align:'center'},
			//{field:'rcdate',title:'预约时间',width:'9%',sortable:true},
			{field:'rcdate',title:'预约时间',width:'9%'},
			{field:'Tag',title:'标签',width:"12%"},
			{field:'comment',title:'备注',width:'10%'},
			//{field:'wangwang',title:'旺旺号'},
			{field:'shop',title:'店铺',width:'7%'},
			{field:'price',title:'价格',width:'7%'},
			{field:'deposit',title:'订金',width:'7%'},
			{field:'child',title:'小孩信息',width:'7%'},
			//{field:'renbao_user',title:'人保账号'}, 
			//{field:'renbao_password',title:'人保密码'}, 			
			{field:'childad',title:'随迁',width:'7%'},
			{field:'adderss',title:'迁入地',width:'7%'},
			{field:'sbtype',title:'申报类型',width:'7%'},
			{field:'speed_time',title:'进度日期',width:'7%'},
			//{field:'update_time',title:'修改时间',width:'10%'},
			//{field:'upuser',title:'修改人',width:'10%'},
			{field:'wuser',title:'外勤',width:'5%'},
			{field:'up_log',title:'日志',width:'25%'},
		]],
		//用户双击事件
		onDblClickRow:function(index,obj){			
			//updata(obj);
			$('#tabs').tabs('select','详情页');
			t_load(obj);
		},
		onRowContextMenu:function(e,index,row){
			e.preventDefault();//屏蔽浏览器右击事件
			$('#dg').datagrid('selectRow',index);
			console.log(e);
			$('#mm').menu('show', {    
			  left: e.clientX,    
			  top: e.clientY    
			});   			
			//updata(row);
		},
		onSelect:function(index){
			//用户选择时保存索引
			select_index = index;
		},
		onLoadSuccess:function(data){//数据加载成功触发
			//保存上一次请求方法 get or sousou 
			$('#dg_type').val(data.type);
            if(select_index != null)
			   $('#dg').datagrid('selectRow',select_index);
		},

 		rowStyler:function(index,row){
			//大于2天的高亮显示
			if(row.rcdate!=null){
				if(diffTime(row.rcdate) < 2){
				   //console.log(diffTime(row.rcdate));
				   //console.log(row.name);
				   return 'color:blue;';
				}
			}
		}	
	
	});
	
	
	
	
	
	
	
	
	//绑定搜索按钮
    $('#search').bind('click', function(){    
        //提交搜搜
        $('.searchbox-button').trigger("click");
    });
    
	//下载按钮
    $("#dow").bind('click',function(){
    	var name = $('#ss').searchbox('getName'); 
    	var value = $('#ss').searchbox('getValue'); 
    	var text= "&"+name+"="+encodeURIComponent(value);      
    	var params = $("#form_search").serialize();
			params = params+text;   	
    	window.location.href="/ui/home/xls?"+params;
    })
	
	//搜索表单
	$('#form_search').form({    
	    url:"/api/gdata/sousou",    
	    onSubmit: function(obj){    
	    	//console.log(obj);
	    },    
	    //返回DATA json
	    success:function(data){    
	        var obj = $.parseJSON(data);
	        if (obj.code< 1) {
	        	$.messager.alert('警告',obj.msg,"warning");  
	        	return;
	        }
	        $('#dg').datagrid('loadData',obj);
	    }    
	});  
	
   //业务员搜索列表框初始化
   $('#user').combobox({
   		panelHeight:"auto",
   		url:'/ui/home/getUserNameList',    
    	valueField:'name',    
    	textField:'name'   
   })
	
	//表格右键菜单
	$('#mm').menu({    
	    onClick:function(item){    
			//console.log(item);
			but_ajax_post('/api/gdata/setstatus',item.text);//set_status(item.text);
	    }   
	});  
})