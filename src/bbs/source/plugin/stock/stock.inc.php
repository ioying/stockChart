<?php
/*
	Formula Editor 
	Copyright (c) 2009-2014 Ioying@hotmail.com (http://www.ttlele.com , http://www.ttall.net)

	$Id: stock.inc.php 2014-1-30 ioying 
	
	！使用 DISCUZ_ROOT. 规范所有目录      ....换不同服务器不灵啊， 555 ，考虑使用 dirname(__file__) 兼容性差 20140222
	
*/
if(!defined('IN_DISCUZ')){
	exit('Access Denied');
}

		//调试
		//showmessage($_GET['mod'] . $_GET['stockid']);
		//set_time_limit(50);
		//error_reporting(E_ALL);

	//浏览器识别
	include './source/plugin/stock/func/getbrowser.func.php'; 
	$browser = new Browser();
	if ($browser->isIE()){
		$ShowIeBugMessage = "  非常抱歉！IE 浏览器提示页面错误，不能正常显示，正在调试修改中，请先使用其他浏览器";
	}else{
		$ShowIeBugMessage = "";
	}


	include './source/plugin/stock/func/getcsvfromyahoo.func.php';  // 



/* 
	if(!empty($_GET['mod']) && !$_G['uid']){
		showmessage('not_loggedin', NULL, array(), array('login' => 1));
	}elseif(preg_match("/X1.5/i", $_G['setting']['version'])){
		if($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST)){
			$_GET = array_merge($_GET, $_POST);
		}
	} 
*/

if(empty($_GET['mod'])){
		include template ( 'stock:test' );
		
/////////  **** drawjs  ****  ///////javascript 版////////////////////////////////

}elseif($_GET['mod'] == 'drawjs'){  
	
$FormulaSet = array( "ma"); //,,"vol" ,"vol", "macd"
foreach ($FormulaSet as $NowFormula){
				$needupdate = 0;
				//	include './func/getcsvfromyahoo.func.php';  //  函数化 
			$test=$test1='';         //调试 及错误信息
		if(!empty($_POST['stock_code'])){
			$formula_name  =  $NowFormula ;  //'ma' 暂时赋值，以后从数据库读取， 未登录用户使用默认演示数据
			$stock_code    =  $_POST['stock_code'];
			$cycle         =  $_POST['cycle']; 
		}else{
			$formula_name  = 'ma';
			$stock_code    =  '510050.ss';
			$cycle         =  'd'; 
		}	
		//	echo $NowFormula;
 			$try=getcsvfromyahoo($stock_code,$cycle); //检查原始数据文件，根据需要 get from yahoo api
 			if (!$try){
					$test1 .=		 ' 没找到数据源，可能是代码错误或数据服务器故障。 <br>';
			}else{    ////					$test1.=	 ' yahoo api 数据获取成功<br> ';
				$file_name  = './source/plugin/stock/data/'.$stock_code.'_'.$cycle.'.csv';
				$userfile_name = './source/plugin/stock/data/userdata/'.$stock_code.'_'.$cycle.'_'.$formula_name.'.json';	
				$short_name = $stock_code.'_'.$cycle.'_'.$formula_name.'.json';	

					if (file_exists($userfile_name)) {    //判断user数据文件是否存在
						$shicha=filemtime($file_name)-filemtime($userfile_name);
// $test1 .= $shicha;
						if ($shicha > 1) {      	  // 行情数据 比 用户数据文件 新 未更新
// 							$test1.=	 ' too old ,need update<br>';					//更新
							$needupdate = 1;
						}else{
// 							$test1.=	 ' very young, dont update<br>';                    //不用更新
							//$needupdate = 0;
						}
					
						//$test1 .= $userfile_name.'zai';
					}else{     //数据文件不存在
						$needupdate = 1;
//						$test1 .= 'not found userdata, calculate!<br>';
					}
					
					$check = DB::fetch_first("SELECT id,parser,lastupdate,comment,formulaname ,mainmap FROM ".DB::table('stock')." WHERE formulaname='$formula_name'");
					// 还有检验 公式最后更新时间，如果是公式新更新过，则需要重新计算。
					if($needupdate == 0 && $check['lastupdate'] > filemtime($userfile_name)){
					$needupdate = 1;
					}
					if(!$check['id']){
//		showmessage('stock:stock_inc_php_2'.'8888', 'plugin.php?id=stock&mod=user_formula');
									$test1 .= '  公式未找到！'.'<br>';	
								//	$needupdate = 0;
					}else{
							DB::query("UPDATE ".DB::table('stock')." SET hots = hots + 1 WHERE formulaname='$formula_name'");

 //							$test1 .= 'found formula ID:'.$check['id'].'<br>'.$check['parser'].'<br>';
					//			$needupdate = 1;
					}
			
			if ($needupdate == 1){

 //			$test1 .='ready to update<br>';

				$arrtest = json_decode(htmlspecialchars_decode($check['parser']), true);
				include './source/plugin/stock/yahoocsv.inc.php';
				include './source/plugin/stock/calculatefordrawjs.inc.php';
				$data = json_encode($arrtest);
				//$test1 .= getcwd();
							//	$test1 .= $data.'<br>';
				file_put_contents($userfile_name,$data);

//$put_ok=    $test1 .='put file down:'.$put_ok.'<br>';
			
			}else{
//			$test1 .="what's up";
			}
		$make_chart[]='<iframe width=100% height=460 frameborder=0 src="source/plugin/stock/drawjs.inc.php?fdataid='.$short_name.'&mainmap='.$check['mainmap'].'&stock_name='.urlencode ( $_GET['stock_name']).'&formula_name='. $formula_name.'"></iframe>' ;
		
		//.'		<a href="source/plugin/stock/drawjs.inc.php?fdataid='.$short_name.'&mainmap=1&stock_name='.urlencode ( $_GET['stock_name']).'&formula_name='. $formula_name.' target="_blank">For Android</a>'		;
//		$test1 .= htmlspecialchars ( $_GET['stock_name']);
//	htmlspecialchars ()	$test1 .='xxxxx'. $short_name;			
/* 	
 	if (function_exists('yahoocsv')) {
    $test1 .= "found yahoocsv";
} else {
    $test1 .= "not found yahoocsv";;
}  */
	} 
	
}	
//$test=$file_name.$userfile_name.getcwd();
include template ( 'stock:drawjs' );


///////////******* user_formula ********///////////////////////////////////////////
}elseif($_GET['mod'] == 'user_formula'){

				if(!empty($_GET['mod']) && !$_G['uid']){
					showmessage('not_loggedin', NULL, array(), array('login' => 1));
				}elseif(preg_match("/X1.5/i", $_G['setting']['version'])){
					if($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST)){
						$_GET = array_merge($_GET, $_POST);
					}
				}

if(submitcheck('testsubmit')){
showmessage('testsubmit ok!');
}
	if(submitcheck('del_formula')){
		$stocksadd = '';
		if($stockids = dimplode($_GET['delete'])){
			$stocksadd = "id IN ($stockids)";
		}
		showmessage($stockids);
		if(!$stocksadd){
			showmessage('stock:stock_inc_php_2', 'plugin.php?id=stock&mod=user_formula');
		}else{
			DB::query("DELETE FROM ".DB::table('stock')." WHERE $stocksadd");
			showmessage('stock:stock_inc_php_6', dreferer());
		}
	}
//	showmessage('here2');
	$num = DB::result_first("SELECT COUNT(*) FROM ".DB::table('stock')." WHERE uid='$_G[uid]'");
//	showmessage($num);
	$page = $_G['page'] > 10 ? 1 : $_G['page'];
	$start_limit = ($page - 1) * 20;
	$multipage = multi($num, 20, $page, "plugin.php?id=stock&mod={$_GET[mod]}");
	$query = DB::query("SELECT * FROM ".DB::table('stock')." WHERE uid='$_G[uid]' ORDER BY id DESC LIMIT $start_limit, 20");
	$stocklist_user = array();
	while($stock_user = DB::fetch($query)){
		$stock_user['dateline'] = dgmdate($stock_user['dateline'], 'dt', $_G['setting']['timeoffset']);
		$stocklist_user[] = $stock_user;
	}
	
}elseif($_GET['mod'] == 'edit_formula' && $_GET['stockid']){

				if(!empty($_GET['mod']) && !$_G['uid']){
					showmessage('not_loggedin', NULL, array(), array('login' => 1));
				}elseif(preg_match("/X1.5/i", $_G['setting']['version'])){
					if($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST)){
						$_GET = array_merge($_GET, $_POST);
					}
				}
	$check = DB::fetch_first("SELECT id FROM ".DB::table('stock')." WHERE id='".intval($_GET['stockid'])."' AND uid='$_G[uid]'");
	if(!$check['id']){
		showmessage('stock:stock_inc_php_2'.'8888', 'plugin.php?id=stock&mod=user_formula');
	}

	
	if(submitcheck('Submit_edit')){
		if (!trim($_GET['after_parser'])){
			showmessage('请先点击“测试解析”按钮,通过测试');
		}
//		if (!trim($_GET['fathername']) and !trim($_GET['mothername']) ){
			if(!trim($_GET['formulaname']) or !trim($_GET['formula'] )){
			//公式名字和代码不能 为空  命名规则 同php变量命名
						showmessage('stock:stock_inc_php_nameplease');
		//if(!trim($_GET['message'])){
		//	showmessage('stock:stock_inc_php_4');
		}else{

		
			DB::query("UPDATE ".DB::table('stock')." SET 
			formulaname='".daddslashes(dhtmlspecialchars($_GET['formulaname']))."',
			description='".daddslashes(dhtmlspecialchars($_GET['description']))."',			
			comment='".daddslashes(dhtmlspecialchars($_GET['comment']))."',			
			formula='".daddslashes(dhtmlspecialchars($_GET['formula']))."',
			parser='".daddslashes(dhtmlspecialchars($_GET['after_parser']))."',			
			mainmap='".intval($_GET['mainmap'])."',
			Permission='".intval($_GET['Permission'])."',
			lastupdate='".time()."',
			message='".daddslashes(dhtmlspecialchars($_GET['message']))."' 
			WHERE id='".intval($_GET['stockid'])."'");
			showmessage('stock:stock_inc_php_5', 'plugin.php?id=stock&mod=user_formula');
		}
	}
	$query = DB::query("SELECT * FROM ".DB::table('stock')." WHERE id='".intval($_GET['stockid'])."'");
	$stocklist_edit = array();
	while($stock_edit = DB::fetch($query)){
		$stocklist_edit[] = $stock_edit;
	}
	include template ( 'stock:edit' );
}elseif($_GET['mod'] == 'members_formula'){

if(!empty($_GET['mod']) && !$_G['uid']){
	showmessage('not_loggedin', NULL, array(), array('login' => 1));
}elseif(preg_match("/X1.5/i", $_G['setting']['version'])){
	if($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST)){
		$_GET = array_merge($_GET, $_POST);
	}
}
	$num = DB::result_first("SELECT COUNT(*) FROM ".DB::table('stock')."");
	$page = $_G['page'] > 20 ? 1 : $_G['page'];
	$start_limit = ($page - 1) * 20;
	$multipage = multi($num, 20, $page, "plugin.php?id=stock&mod={$_GET[mod]}");
	$query = DB::query("SELECT * FROM ".DB::table('stock')." ORDER BY id DESC LIMIT $start_limit, 20");
	$stocklist_members = array();
	while($stock_members = DB::fetch($query)){
		$stock_members['dateline'] = dgmdate($stock_members['dateline'], 'dt', $_G['setting']['timeoffset']);
		$stocklist_members[] = $stock_members;
	}
	 
}elseif($_GET['mod'] == 'admin_check'){
	if($_G['adminid'] != '1'){
		showmessage('group_nopermission', 'plugin.php?id=stock');
	}
	if(submitcheck('admin_del')){
		$stocksadd = '';
		if($stockids = dimplode($_GET['delete'])){
			$stocksadd = "id IN ($stockids)";
		}
	//	showmessage($stockids);
		if(!$stocksadd){
			showmessage('stock:stock_inc_php_2', 'plugin.php?id=stock&mod=admin_check');
		}else{
			DB::query("DELETE FROM ".DB::table('stock')." WHERE $stocksadd");
			showmessage('stock:stock_inc_php_6', dreferer());
		}
	}
	$num = DB::result_first("SELECT COUNT(*) FROM ".DB::table('stock')."");
	$page = $_G['page'] > 10 ? 1 : $_G['page'];
	$start_limit = ($page - 1) * 10;
	$multipage = multi($num, 10, $page, "plugin.php?id=stock&mod={$_GET[mod]}");
	$query = DB::query("SELECT * FROM ".DB::table('stock')." ORDER BY id DESC LIMIT $start_limit, 10");
	$stocklist_admin = array();
	while($stock_admin = DB::fetch($query)){
		$stock_admin['dateline'] = dgmdate($stock_admin['dateline'], 'dt', $_G['setting']['timeoffset']);
		$stocklist_admin[] = $stock_admin;
	}

}elseif($_GET['mod'] == 'add_Formula'){
	if(submitcheck('Submit_member')){
			if(!trim($_GET['formulaname']) or !trim($_GET['formula'] )){
			//公式名字和代码不能同时为空
						showmessage('stock:stock_inc_php_nameplease');

		}else{
//								showmessage($_GET['formulaname']);
//description  comment  
			
			DB::query("INSERT INTO ".DB::table('stock')." (uid,username,formulaname,description, mainmap,comment,formula,dateline) VALUES ('$_G[uid]','$_G[username]','".daddslashes(dhtmlspecialchars($_GET['formulaname']))."','".daddslashes(dhtmlspecialchars($_GET['description']))."','".intval($_GET['mainmap'])."','".daddslashes(dhtmlspecialchars($_GET['comment']))."','".daddslashes(dhtmlspecialchars($_GET['formula']))."','$_G[timestamp]')");
			showmessage('stock:stock_inc_php_10', 'plugin.php?id=stock');
		}
	}

}else{
	showmessage('undefined_action', NULL, 'HALTED');
}

include template('stock:stock');
?>