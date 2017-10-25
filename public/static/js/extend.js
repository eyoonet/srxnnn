
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
	/**
	 * 格式表单到json对象 jquery 扩展
	 * @returns {{}}
	 */
	$.fn.serializeObject = function() {
		var o = {};
		var a = this.serializeArray();
		$.each(a, function() {
			if (this.value != ""){
				if (o[this.name]) {
					if (!o[this.name].push) {
						o[this.name] = [ o[this.name] ];
					}
					o[this.name].push(this.value || '');
				} else {
					o[this.name] = this.value || '';
				}
			}
		});
		return o;
	}
})