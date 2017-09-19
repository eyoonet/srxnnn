function t_load(obj){
		//必须释放图片给下一次使用
	$('#dowebok2').viewer('destroy');
	$("#dowebok2").empty();//清空图片箱子    
	$("#t-name").html(obj.name);//填充姓名
	$("#t-sex").html(obj.sex);
	$("#t-education").html(obj.education);
	$("#t-card").html(obj.card);//填充身份证
	$("#t-tel").html(obj.tel);
	$("#t-price").html(obj.price);
	$("#t-deposit").html(obj.deposit);
	$("#t-wangwang").html(obj.wangwang);
	$("#t-renbao").html(obj.renbao_user);
	$("#t-renbao-pw").html(obj.renbao_password);
	
	//$("#t-comment").val(obj.comment);
	//$('#t-comment').textbox('setText',obj.comment);
	$('#t-comment').textbox('setValue',obj.comment);
	$('#t-comment').textbox('readonly');	                // 启用只读模式

	
	$("#t-speed").html(obj.speed);
	//$("#t-speed_time").html(obj.speed_time);
	$("#t-add_time").html(obj.add_time);
	$("#t-user").html(obj.user);
	$("#t-adderss").html(obj.adderss);
	$("#t-mode").html(obj.mode);
	$("#t-child").html(obj.child);
	$("#t-childad").html(obj.childad);
	$("#t-shebao").html(obj.shebao);
	$("#t-marriage").html(obj.marriage);
     //zdtype status level Tag sbtype add_time shop
    $("#t-zdtype").html(obj.zdtype);
    $("#t-status").html(obj.status);
    $("#t-level").html(obj.level);
    $("#t-sbtype").html(obj.sbtype);
    $("#t-add_time").html(obj.add_time);
    $("#t-Tag").html(obj.Tag);
    $("#t-shop").html(obj.shop);
    $("#t-rcdate").html(obj.rcdate);
	$.get("/upimage/getpic.php?card="+obj.card, function(data){
	  var obj2 = $.parseJSON(data);
	  var img2 ="side:'bottom'";
	  for(var i=0;i<obj2.length;i++){
		 //var img ="<div><a href='/UpImage/server/"+obj.card+"/"+obj2[i]+"' class='strip' data-strip-group='shared-options' data-strip-group-options="+img2+"><img src='/UpImage/server/"+obj.card+"/"+obj2[i]+"' class='img-polaroid'></a></div>";
	     var img = "<li><div>"+obj2[i]+"</div><img data-original='/UpImage/server/"+obj.card+"/"+obj2[i]+"' src='/UpImage/server/"+obj.card+"/"+obj2[i]+"' alt='"+obj2[i]+"'></li>"
	     //$(".imagebox").append(img);
	     // <a alt="+obj.card+"\\"+obj2[i]+" href='javascript:' onclick='delpic(this)'>删除</a>
		 $("#dowebok2").append(img);
	  }
	    setTimeout(function () { 
			var top = $('.layout-panel-north')
			var bottom = $('.layout-panel-south')
			var west =  $('.layout-panel-west')
			$('#dowebok2').viewer({
				url: 'data-original',
				shown: function() {
					top.hide();
					bottom.hide();
					west.hide();
					//top.css({ z-index: 0 });
				},
				hide: function() {
					west.show();
					top.show();
					bottom.show()
				},				
			});		       
	    }, 1000);			

	});		
}
function delpic(_pic,card){
	f = $(_pic).attr("alt");
	alert(card);
	var url = "/api/gdata/delpic?file="+f;
	$.get(url, function(data){
	  alert("Data Loaded: " + data);
	});
}
$(function($){

})