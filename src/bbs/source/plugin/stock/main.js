


// JavaScript Document

// spin 载入效果
/*
      var opts = {            
            lines: 13, // 花瓣数目
            length: 20, // 花瓣长度
            width: 10, // 花瓣宽度
            radius: 30, // 花瓣距中心半径
            corners: 1, // 花瓣圆滑度 (0-1)
            rotate: 0, // 花瓣旋转角度
            direction: 1, // 花瓣旋转方向 1: 顺时针, -1: 逆时针
            color: '#5882FA', // 花瓣颜色
            speed: 1, // 花瓣旋转速度
            trail: 60, // 花瓣旋转时的拖影(百分比)
            shadow: false, // 花瓣是否显示阴影
            hwaccel: false, //spinner 是否启用硬件加速及高速旋转            
            className: 'spinner', // spinner css 样式名称
            zIndex: 2e9, // spinner的z轴 (默认是2000000000)
            top: 'auto', // spinner 相对父容器Top定位 单位 px
            left: 'auto'// spinner 相对父容器Left定位 单位 px
        };
*/
//        var spinner = new Spinner(opts);
//  spin 初始结束		


var xmlHttp
function clear()
{
	document.getElementById("text").clear ;
	document.getElementById("text").focus ;
}

function addfunc(str)
{
// 	alert(editor.getValue())
	editor.setValue(editor.getValue()+str);
//  editor.setValue(document.getElementById("formula").value+str);
//	document.getElementById("formula").value=document.getElementById("formula").value+str;
//	alert("提交的内容为："+str+document.getElementById("formula").value+"***" );
}

function submitparser()
{ 

xmlHttp=GetXmlHttpObject();
if (xmlHttp==null)
  {
  alert ("您的浏览器不支持AJAX！");
  return;
  } 

//var url='http://localhost/newstock/parser.inc.php'  ;
var url='./source/plugin/stock/parser.inc.php';
//alert(url);
//var url="./source/plugin/stock/parser.inc.php";  
//高亮代码获取textarea 当前值
var text1=editor.getValue()
var encode_content=escape(text1);
var content="text="+encode_content;
content=content.replace(/\+/g, "%2b"); 
//alert("提交的内容为："+content);
//url=url+"?q="+str;
//url=url+"&sid="+Math.random();
xmlHttp.onreadystatechange=parser_Changed;
xmlHttp.open("POST",url,true);
xmlHttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded"); 
xmlHttp.send(content);
}






function submitcontent_old()
{ 


xmlHttp=GetXmlHttpObject();
if (xmlHttp==null)
  {
  alert ("您的浏览器不支持AJAX！");
  return;
  } 
  
//var url="./source/plugin/stock/post_to_host.inc.php";  
var url="./source/plugin/stock/getpost.inc.php";
//var content="postcontent="+escape(document.getElementById("message"));
//var content="postcontent="+escape(document.getElementById("func").value)+"&url="+escape(url)+"&text="+escape(document.getElementById("text").value);

//高亮代码获取textarea 当前值
var text1=editor.getValue()
//普通textarea 当前值 var text1=document.getElementById("formula").value;
var encode_content=escape(text1);
//encode_content=encode_content.replace("+", "%20"); 
//alert(encode_content);
//alert(text1);
//var content="text="+escape(document.getElementById("formula").value)+"&select_cycle="+escape(document.getElementById("select_cycle").value);
var content="text="+encode_content;
//+"&select_cycle="+escape(document.getElementById("select_cycle").value);
content=content.replace(/\+/g, "%2b"); 
//alert("提交的内容为："+content);
//url=url+"?q="+str;
//url=url+"&sid="+Math.random();
xmlHttp.onreadystatechange=stateChanged;
xmlHttp.open("POST",url,true);
xmlHttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded"); 

xmlHttp.send(content);
}
function submitcontent()
{ 


xmlHttp=GetXmlHttpObject();
if (xmlHttp==null)
  {
  alert ("您的浏览器不支持AJAX！");
  return;
  } 

//alert($_GET['moodid']);
// alert('Here Now');
var url="./source/plugin/stock/post_to_host.inc.php";  
//高亮代码获取textarea 当前值
var text1=editor.getValue()
//普通textarea 当前值 var text1=document.getElementById("formula").value;
var encode_content=escape(text1);
//encode_content=encode_content.replace("+", "%20"); 
//alert(encode_content);
//alert(text1);
//var content="text="+escape(document.getElementById("formula").value)+"&select_cycle="+escape(document.getElementById("select_cycle").value);
var content="text="+encode_content;
//+"&select_cycle="+escape(document.getElementById("select_cycle").value);
content=content.replace(/\+/g, "%2b"); 
//alert("提交的内容为："+content);
//url=url+"?q="+str;
//url=url+"&sid="+Math.random();
xmlHttp.onreadystatechange=stateChanged;
xmlHttp.open("POST",url,true);
xmlHttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded"); 
xmlHttp.send(content);
}

function funcTest()
{ 
xmlHttp=GetXmlHttpObject();
if (xmlHttp==null)
  {
  alert ("您的浏览器不支持AJAX！");
  return;
  } 
//alert($_GET['moodid']);
// alert('Here Now');
var url="post_to_host.inc.php";  
var text1=editor.getValue()
var encode_content=escape(text1);
var content="text="+encode_content;
content=content.replace(/\+/g, "%2b"); 
xmlHttp.onreadystatechange=stateChanged;
xmlHttp.open("POST",url,true);
xmlHttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded"); 
xmlHttp.send(content);
}
function funcdraw()
{ 
xmlHttp=GetXmlHttpObject();
if (xmlHttp==null)
  {
  alert ("您的浏览器不支持AJAX！");
  return;
  } 
document.getElementById("chart").innerHTML='<img src="./image/wait7.gif" />请稍候...';
	var userid=document.getElementById("uid").value;
	var radionum = document.getElementById("form1").mainmap;
		for(var i=0;i<radionum.length;i++){
			if(radionum[i].checked){
				mainmap = radionum[i].value
			}
		}
var url="./post_to_host_draw.inc.php?userid="+userid+"&mainmap="+mainmap;  
//高亮代码获取textarea 当前值
var text1=editor.getValue()
//alert(url);
//普通textarea 当前值 var text1=document.getElementById("formula").value;
var encode_content=escape(text1);
var content="text="+encode_content;
content=content.replace(/\+/g, "%2b"); 
xmlHttp.onreadystatechange=statedraw;
xmlHttp.open("POST",url,true);
xmlHttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded"); 
xmlHttp.send(content);
}

function submitdraw()
{ 


xmlHttp=GetXmlHttpObject();
if (xmlHttp==null)
  {
  alert ("您的浏览器不支持AJAX！");
  return;
  } 
//		var target = $("#chart").get(0);
 //		alert('work');
//		spinner.spin(target);              
  //submitparser;
//  var button1 =document.getElementById("parser_it");
//  button1.onclick = buttonClicked;
//alert($_G['uid']);
//alert($_GET['moodid']);
//获取用户id，传给php文件，生成JSON文件名
// $("#chart").text("请稍候...");
document.getElementById("chart").innerHTML='<img src="./source/plugin/stock/image/wait7.gif" />请稍候...';
	var userid=document.getElementById("uid").value;
//var mainmap=document.getElementById("mainmap").value;
///////////读取radio的值 决定图表呈现方式  主图/副图/同时 好麻烦 ！//////////////////////
	var radionum = document.getElementById("form1").mainmap;
		for(var i=0;i<radionum.length;i++){
			if(radionum[i].checked){
				mainmap = radionum[i].value
			}
		}
/////////////////////////////////
//alert(userid);
var url="./source/plugin/stock/post_to_host_draw.inc.php?userid="+userid+"&mainmap="+mainmap;  
//高亮代码获取textarea 当前值
var text1=editor.getValue()
//alert(url);
//普通textarea 当前值 var text1=document.getElementById("formula").value;
var encode_content=escape(text1);
var content="text="+encode_content;
content=content.replace(/\+/g, "%2b"); 
xmlHttp.onreadystatechange=statedraw;
xmlHttp.open("POST",url,true);
xmlHttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded"); 
xmlHttp.send(content);
//		var target = $("#chart").get(0);
// 		alert('work');
//		spinner.spin(target);              
}

function statedraw()
{ 
	if (xmlHttp.readyState==4)
		{ 
//		var drawtext='<iframe width=100% height=460 frameborder=1 src="source/plugin/stock/candle.inc.php?fdataid=1112"></iframe>'
//					document.getElementById("chart").innerHTML=drawtext;
// 			 spinner.spin();
			document.getElementById("chart").innerHTML=xmlHttp.responseText;
			
//            set_innerHTML('chart',xmlHttp.responseText);
//			document.getElementById("after_parser").innerHTML=xmlHttp.responseText;
		}
}


function stateChanged()
{ 
if (xmlHttp.readyState==4)
{ 
//alert('what?');
document.getElementById("txtHint").innerHTML=xmlHttp.responseText;
//document.getElementById("time").innerHTML=xmlHttp.responseText;
//document.myForm.time.value=xmlHttp.responseText;
}
}

function parser_Changed()
{ 
if (xmlHttp.readyState==4)
{ 
document.getElementById("after_parser").innerHTML=xmlHttp.responseText;
document.getElementById("Submit_edit").disabled='';
//document.getElementById("time").innerHTML=xmlHttp.responseText;
//document.myForm.time.value=xmlHttp.responseText;
}
}


function GetXmlHttpObject()
{
var xmlHttp=null;
try
  {
  // Firefox, Opera 8.0+, Safari
  xmlHttp=new XMLHttpRequest();
  }
catch (e)
  {
  // Internet Explorer
  try
    {
    xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
    }
  catch (e)
    {
    xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
  }
return xmlHttp;
}