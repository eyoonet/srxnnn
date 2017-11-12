var select_index;
var click = false;
$(function ($) {
    $('#dg').datagrid({
        //title:'用户列表', //标题
        //method:'post',
        //iconCls:'icon-edit', //图标
        fit: true,
        singleSelect: true, //多选
        fitColumns: true, //自动调整各列，用了这个属性，下面各列的宽度值就只是一个比例。
        striped: true, //奇偶行颜色不同
        collapsible: false,//可折叠
        url: "data/DGlist", //数据来源
        sortName: 'rcdate', //排序的列
        sortOrder: 'desc', //倒序
        remoteSort: true, //服务器端排序
        idField: 'id', //主键字段
        queryParams: {}, //查询条件
        pagination: true, //显示分页
        rownumbers: true, //显示行号
        pageSize: 15,
        pageList: [15, 30, 45, 60, 75],
        toolbar: "#Dg-toobar",
        columns: [[
            {
                field: 'id', title: '操作', width: 65, formatter: function (value, row, index) {
                return '<a class="button-default" href="#">约号</a> ' +
                    '<a class="button-danger" href="#">取消</a>';
            }
            },
            {field: 'name', title: '姓名', width: "5%"},
            {field: 'card', title: '身份证号', width: '12%'},
            {field: 'tel', title: '电话', width: '8%'},
            {field: 'mode', title: '入户方式', align: 'center', width: '5%'},
            {field: 'status', title: '工作流', width: '5%'},
            // {field:'education',title:'学历',width:'3%'},
            {field: 'shebao', title: '社保', align: 'center', width: '4%'},
            {field: 'service', title: '窗口', width: '7%'},
            //{field:'marriage',title:'婚姻',align:'center',width:'4%'},
            {field: 'speed', title: '进度', align: 'center', width: '6%'},
            {field: 'user_name', title: '业务员', width: '4%'},
            //{field:'add_time',title:'添加时间',width:'7%'},
            {field: 'dangan', title: '调档', width: '2%', align: 'center'},
            //{field:'rcdate',title:'预约时间',width:'9%',sortable:true},
            {field: 'rcdate', title: '人才网时间', width: '9%', sortable: true},
            {field: 'Tag', title: '标签', width: "12%"},
            {field: 'comment', title: '备注', width: '10%'},
            //{field:'wangwang',title:'旺旺号'},
            //{field:'shop',title:'店铺',width:'7%'},
            //{field:'price',title:'价格',width:'7%'},
            //{field:'deposit',title:'订金',width:'7%'},
            //{field:'child',title:'小孩信息',width:'7%'},
            //{field:'renbao_user',title:'人保账号'},
            //{field:'renbao_password',title:'人保密码'},
            //{field:'childad',title:'随迁',width:'7%'},
            //{field:'adderss',title:'迁入地',width:'7%'},
            {field: 'sbtype', title: '申报类型', width: '5%'},
            //{field:'speed_time',title:'进度日期',width:'7%'},
            {field:'shebaoname',title:'社保公司',width:'15%'},
            //{field:'upuser',title:'修改人',width:'10%'},
            //{field:'wuser',title:'外勤',width:'5%'},
        ]],

        //右键
        onRowContextMenu: function (e, index, row) {
            e.preventDefault();//屏蔽浏览器右击事件
            $('#dg').datagrid('selectRow', index);
            console.log(e);
            $('#mm').menu('show', {
                left: e.clientX,
                top: e.clientY
            });
        },
        //用户选择时保存索引
        onSelect: function (index) {
            select_index = index;
        },
        //数据加载成功触发
        onLoadSuccess: function (data) {
            $('#dg_type').val(data.type);
            if (select_index != null)
                $('#dg').datagrid('selectRow', select_index);
        },
        //大于2天的高亮显示 这里好像表会被刷新
        rowStyler: function (index, row) {
            if (row.rcdate != null) {
                if (diffTime(row.rcdate) < 2) {
                    return 'color:blue;';
                }
            }
        },
        //双击单元格
        onDblClickCell: function (index, field, value) {
            console.log(index + field + value);
            if (field == "comment") {
                $("#comm-but").trigger("click");
                click = true;
            } else if (field == "Tag") {
                $("#tag-but").trigger("click");
                click = true;
            } else {
                click = false;
            }
        },
        //用户双击事件
        onDblClickRow: function (index, obj) {
            if (click) return;//解决冲突
            //$('#tabs').tabs('select','详情页');
            loadtable(obj);
            images(obj.card);
        }
    });
})

function images(card) {
    //必须释放图片给下一次使用
    $('#dowebok').viewer('destroy');
    $("#dowebok").empty();//清空图片箱子
    $.getJSON("/data/imageList?idcard=" + card, function (data) {
        console.log(data);
        for (var i = 0; i < data.length; i++) {
            var image = '/upload/idcards/' + card + '/' + data[i];
            var img =

                '<li>' +

                '<div>' + data[i] + ' <a href="javascript:"> 删除 </a></div>' +

                '<img data-original="' + image + '" src="' + image + '" alt="' + data[i] + '">' +


                '</li>'

            $("#dowebok").append(img);
        }
        setTimeout(function () {
            //需要隐藏遮挡物
            var top = $('.layout-panel-north')
            var bottom = $('.layout-panel-south')
            var west = $('.layout-panel-west')
            $('#dowebok').viewer({
                url: 'data-original',
                shown: function () {
                    /* top.hide();
                     bottom.hide();
                     west.hide();*/
                    //top.css({ z-index: 0 });
                },
                hide: function () {
                    /*west.show();
                     top.show();
                     bottom.show()*/
                },
            });
        }, 1000);
    });
}




