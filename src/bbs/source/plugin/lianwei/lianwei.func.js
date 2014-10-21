/*
	[smjy] Yingling Lianwei
	Copyright (c) 2009-2013 smjy(http://www.smjy.org)
	$Id: extend_common.css 2013-12-21 smjy $
*/

function checkLength(string,maxlength){
//修改了函数，增加了maxlength 参数，即最大长度参数，使得能用于其他字段长度校验 2013.12.24 by ioying
	var maxChars = maxlength;
	
	if(string.value.length > maxChars){  //截短字符串
		string.value = string.value.substring(0,maxChars);
	}
	jQuery('#chLeft').text((maxChars - string.value.length).toString()); //返回剩余可输入长度
}

function remove(id){
	jQuery('#'+id).fadeOut('slow', function(){
		jQuery(this).remove();
	});
}

jQuery.noConflict();
jQuery(document).ready(function(){
	jQuery('.drag').draggable({containment:'#contentarea',cursor:'move',opacity:0.85,stack:'.drag'});
});