var select_index;
$(function($){
	$('#dg').datagrid({
        //title:'用户列表', //标题
        //method:'post',
        //iconCls:'icon-edit', //图标
        singleSelect:true, //多选
        height:570, //高度
        fitColumns: true, //自动调整各列，用了这个属性，下面各列的宽度值就只是一个比例。
        striped: true, //奇偶行颜色不同
        collapsible:false,//可折叠
        url:"static/js/data.json", //数据来源
        sortName: 'user.id', //排序的列
        sortOrder: 'desc', //倒序
        remoteSort: true, //服务器端排序
        idField:'uid', //主键字段
        queryParams:{}, //查询条件
        pagination:true, //显示分页
        rownumbers:true, //显示行号
		pageSize:15,
		pageList:[15,30,45,60,75],
		toolbar:"#Dg-toobar",
		columns:[[    
			{field:'name',title:'姓名',width:"5%"},    
			{field:'card',title:'身份证号',width:'11%'},
			{field:'tel',title:'电话',width:'7%'},     
			{field:'mode',title:'入户方式',align:'center',width:'6%'},	
			{field:'status',title:'工作流',width:'7%'},	 
			{field:'education',title:'学历',width:'3%'}, 
			{field:'shebao',title:'社保',align:'center',width:'4%'},
		    {field:'service',title:'窗口',width:'5%'}, 
		    //{field:'marriage',title:'婚姻',align:'center',width:'4%'},
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
			$('#tabs').tabs('select','详情页');
		},
		//右键
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
		//用户选择时保存索引
		onSelect:function(index){
			select_index = index;
		},
		//数据加载成功触发
		onLoadSuccess:function(data){
			$('#dg_type').val(data.type);
            if(select_index != null)
			   $('#dg').datagrid('selectRow',select_index);
		},
        //大于2天的高亮显示
 		rowStyler:function(index,row){
			if(row.rcdate!=null){
				if(diffTime(row.rcdate) < 2){
				   //console.log(diffTime(row.rcdate));
				   //console.log(row.name);
				   return 'color:blue;';
				}
			}
		}
	});

	//表格右键菜单
	$('#mm').menu({    
	    onClick:function(item){    
			//console.log(item);

	    }   
	});  
})