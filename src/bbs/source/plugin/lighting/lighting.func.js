/*
	[Teen Studio] Mood Wall
	Copyright (c) 2009-2012 Teen Studio(http://teen-s.coms.hk)
	$Id: lighting.func.js 2012-8-30 Marco129 $
*/

function checkLength(string){
	var maxChars = 100;
	if(string.value.length > maxChars){
		string.value = string.value.substring(0,maxChars);
	}
	jQuery('#chLeft').text((maxChars - string.value.length).toString());
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