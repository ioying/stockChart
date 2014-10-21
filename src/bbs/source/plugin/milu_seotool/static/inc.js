var $j = jq = jQuery.noConflict();
// Use jQuery via $j(...)
$j(document).ready(function(){
});

if(PLUGIN_URL) var RPC_URL = PLUGIN_URL+'system_rules&tpl=no&myac=rpcServer&inajax=1';
var RPC_FUNCTIONS = ['test_window', ];


function show_html_window(k, title, width, height, html, c){
	if(c==1) {
		c_html = 'text-align:center';
	}else{
		c_html = 'text-align:left';
	}
	show_html = '<h3 class="flb">'+title+'<span><a href="javascript:;" class="flbc" onclick="hideWindow(\''+k+'\');" title="关闭">点击就关闭窗口</a></span></h3><div class="article_detail c" style="width:'+width+'px;height:'+height+'px;overflow-y:scroll; '+c_html+'">'+ html+'</div>';
	showWindow(k, show_html, 'html');
}

function st_format_url(url){
	if(!url) return;
	var reg1=new RegExp('<','g');
	var reg2=new RegExp('>','g');
	var reg3=new RegExp('"','g');
	url = url.replace(reg1,'[[JK%');
	url = url.replace(reg2,'JK%]]');
	url = url.replace(reg3,'[yinhao');
	return encodeURIComponent(url);
}

function loading_html(msg){
	return loading = '<em><img src="static/image/common/loading.gif"> '+msg+'...</em>';
}


function _tips(key){
	$j.post(PLUGIN_URL+'member&myac=seotool_ajax_func&inajax=1&myac=seotool_ajax_func&inajax=1&af=tips_no&key='+key, null,function (msg) {})
}

function show_hide(show,hide,type){
	if(type == 2){
		showdom = hide;
		hidedom = show;
	}else{
		showdom = show;
		hidedom = hide;
	}
	var showarr=showdom.split('+');
	var hidearr=hidedom.split('+');
	for(i=0;i<showarr.length;i++){
		$j('#'+showarr[i]).show();
	}
	for(i=0;i<hidearr.length;i++){
		$j('#'+hidearr[i]).hide();	
	}
}
function plugin_tips(key){
	$j.post(PLUGIN_URL+'flink&myac=seotool_ajax_func&inajax=1&myac=seotool_ajax_func&inajax=1&af=tips_no&key='+key, null,function (msg) {})
}
