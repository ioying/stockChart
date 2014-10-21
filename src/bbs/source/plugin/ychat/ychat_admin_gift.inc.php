<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: admincp_ychat.php 27939 2012-02-17 03:03:07Z chxs $
 */
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$_GET=daddslashes($_GET);
$_POST=daddslashes($_POST);
$ymod=$_GET["ymod"];
$ymod = !$ymod ? 'list' : $ymod;
if($ymod=="list")
{
	$c1="current";
}
else if($ymod=="add")
{
	$c2="current";
}
echo '<ul class="tab1"><li  class="'.$c1.'"><a href="admin.php?action=plugins&operation=config&identifier=ychat&pmod=ychat_admin_gift&ymod=list"><span>'.lang("plugin/ychat","ychat_liulan").'</span></a></li><li class="'.$c2.'"><a href="admin.php?action=plugins&operation=config&identifier=ychat&pmod=ychat_admin_gift&ymod=add"><span>'.lang("plugin/ychat","ychat_add").'</span></a></li>
</ul>';
if($ymod=="list"){

	showtableheader();
	if(isset($_GET['page'])){
              $page = intval($_GET['page']);//dang qian ye
          }
          else {
              $page=1;//dang qian ye
          }
	$pagesize=30;//mei ye shu ju liang
		
			
			$giftarr=C::t("#ychat#ychat_gift_goods")->fetch_all(($page-1)*$pagesize,$pagesize);


			echo '<tr class="header"><td colspan="8"><div>'.lang('plugin/ychat',"ychat_gifts_name").'</div></td><td colspan="8"><div>'.lang('plugin/ychat',"ychat_gifts_category").'</div></td><td colspan="8"><div>'.lang('plugin/ychat',"ychat_gifts_pic").'</div></td><td colspan="8"><div>'.lang('plugin/ychat',"ychat_gifts_picact").'</div></td><td colspan="8"><div>'.lang('plugin/ychat',"ychat_gifts_price").'</div></td><td colspan="8"><div>'.lang('plugin/ychat',"ychat_caozuo").'</div></td></tr>';
			foreach($giftarr as $config_value)
			{
				$giftcategory=C::t("#ychat#ychat_gift_categories")->fetch_by_id($config_value['cid']);
				echo '<tr class="hover"><td colspan="8"><div>'.$config_value["name"].'</div></td><td colspan="8"><div>'.$giftcategory["name"].'</div></td><td colspan="8"><div><img src="source/plugin/ychat/images/'.$config_value["pic"].'" /></div></td><td colspan="8"><div>'.$config_value["picAct"].'</div></td><td colspan="8"><div>'.$config_value["price"].'</div></td>
				<td colspan="8"><div><a href="'.ADMINSCRIPT.'?action=plugins&operation=config&identifier=ychat&pmod=ychat_admin_gift&ymod=edit&page='.$page.'&giftid='.$config_value["id"].'" >'.lang('plugin/ychat',"ychat_basic_configedit").'</a>&nbsp;&nbsp;<a href="javascript:confirm(\''.lang('plugin/ychat',"ychat_confirm_delete").'\');self.location=\''.ADMINSCRIPT.'?action=plugins&operation=config&identifier=ychat&pmod=ychat_admin_gift&ymod=del&giftid='.$config_value["id"].'\';" >'.lang('plugin/ychat',"ychat_delete").'</a></div>
				</td></tr>';
			}
		showtablefooter();
		$giftcount=C::t("#ychat#ychat_gift_goods")->fetch_count();
		$pagecount=ceil($giftcount/$pagesize);
		echo '<div class="cuspages right"><div class="pg"><em>&nbsp;'.$giftcount.'&nbsp;</em>';
		$startpage=$page-5;
		if($startpage<1)
		{
			$startpage=1;
		}
		for($i=$startpage;$i<=$pagecount&&$i<$startpage+10;$i++)
		{
			if($i==$page)
			{
				echo '<strong>'.$page.'</strong>';
			}
			else
			{
				echo '<a href="admin.php?action=plugins&operation=config&identifier=ychat&pmod=ychat_admin_gift&ymod=list&page='.$i.'">'.$i.'</a>';
			}
		}
		echo '<a href="admin.php?action=plugins&operation=config&identifier=ychat&pmod=ychat_admin_gift&ymod=list&page='.($page+1).'" class="nxt">&rsaquo;&rsaquo;</a><kbd><input type="text" name="custompage" size="3" onkeydown="if(event.keyCode==13) {window.location=\'admin.php?action=plugins&operation=config&identifier=ychat&pmod=ychat_admin_gift&ymod=list&page=\'+this.value; doane(event);}" /></kbd>';
		echo '</div></div>';
	}
	else if($ymod=="add")
	{
		if(!submitcheck('ychatsubmit'))
		{
		showformheader('plugins&operation=config&identifier=ychat&pmod=ychat_admin_gift&ymod=add','enctype');
		showtableheader();
		showsetting(lang('plugin/ychat','ychat_gifts_name'), 'giftname', '', 'text');	
		showsetting(lang('plugin/ychat','ychat_gifts_price'), 'price', '', 'text');
		$tempcategory=C::t("#ychat#ychat_gift_categories")->fetch_all();
		$categoryarr=array();
		foreach($tempcategory as $value)
		{
			array_push($categoryarr,array($value["id"],$value["name"]));
		}
		showsetting(lang('plugin/ychat','ychat_gifts_category'), array('giftcategory', $categoryarr), 1, 'select');
		showsetting(lang('plugin/ychat','ychat_gifts_pic'), 'pic','', 'filetext');	
		showsetting(lang('plugin/ychat','ychat_gifts_picact'), 'picact','', 'filetext');	
	
		showsubmit('ychatsubmit', 'submit');
		showtablefooter();
		showformfooter();
		}
		else
		{
			$giftname=$_POST["giftname"];
			$price=$_POST["price"];
			$giftcategory=$_POST["giftcategory"];
			$reward=$_POST["reward"];
			if($giftname=="")
			{
				cpmsg(lang('plugin/ychat','ychat_gifts_name_null'),'',"error");
			}
			else if($price=="")
			{
				cpmsg(lang('plugin/ychat','ychat_gifts_price_null'),'',"error");
			}
			else if(!is_numeric($price))
			{
				cpmsg(lang('plugin/ychat','ychat_gifts_price_isnumber'),'',"error");
			}
			else
			{
				$timeline=time();
				if($_FILES['pic']["type"])
				{
					$ext=strrchr($_FILES['pic']["name"],".");
					$iconpath='source/plugin/ychat/images/thumbnails/s'.$timeline.$ext;
					$dbiconpath='thumbnails/s'.$timeline.$ext;
					uploadfile($_FILES['pic'],$iconpath);
				}
				else
				{
					$dbiconpath=$_POST["pic"];
				}
				if(empty($dbiconpath))
				{
					cpmsg(lang('plugin/ychat','ychat_gifts_pic_null'),'',"error");
				}
				else
				{
					if($_FILES['picact']["type"])
					{
						$ext=strrchr($_FILES['picact']["name"],".");
						$diconpath='source/plugin/ychat/images/preview/d'.$timeline.$ext;
						$dbdiconpath='preview/d'.$timeline.$ext;
						uploadfile($_FILES['picact'],$diconpath);
					}
					else
					{
						$dbdiconpath=$_POST["picact"];
					}
					if(empty($dbdiconpath))
					{
						cpmsg(lang('plugin/ychat','ychat_gifts_picact_null'),'',"error");
					}
					else
					{
						
						$data=array(
							'cid'=>$giftcategory,
							'name'=>$giftname,
							'pic'=>$dbiconpath,
							'picAct'=>$dbdiconpath,
							'price'=>$price,
							'dateline'=>time(),
							);
						C::t("#ychat#ychat_gift_goods")->insert($data,0,1);
						cpmsg(lang('plugin/ychat','ychat_gifts_success'),'action=plugins&operation=config&identifier=ychat&pmod=ychat_admin_gift&ymod=list','succeed');
					}
				}
			}
		}
	}
	else if($ymod=="edit")
	{
		if(!submitcheck('ychatsubmit'))
		{
		
		showformheader('plugins&operation=config&identifier=ychat&pmod=ychat_admin_gift&ymod=edit&page='.$_GET["page"].'&giftid='.$_GET["giftid"],'enctype');
		showtableheader();
		
		$tempcategory=C::t("#ychat#ychat_gift_categories")->fetch_all();
		$categoryarr=array();
		foreach($tempcategory as $value)
		{
			array_push($categoryarr,array($value["id"],$value["name"]));
		}
		$value=C::t("#ychat#ychat_gift_goods")->fetch_all_by_id($_GET["giftid"]);
		if($value)
		{
			showsetting(lang('plugin/ychat','ychat_gifts_name'), 'giftname', $value["name"], 'text');	
			showsetting(lang('plugin/ychat','ychat_gifts_price'), 'price', $value["price"], 'text');
			showsetting(lang('plugin/ychat','ychat_gifts_category'), array('giftcategory', $categoryarr), $value["cid"], 'select');
			showsetting(lang('plugin/ychat','ychat_gifts_pic'), 'pic',$value["pic"], 'filetext');	
			showsetting(lang('plugin/ychat','ychat_gifts_picact'), 'picact',$value["picAct"], 'filetext');	
			showsubmit('ychatsubmit', 'submit');
		}
		showtablefooter();
		showformfooter();
		}
		else
		{
			$giftname=$_POST["giftname"];
			$price=$_POST["price"];
			$giftcategory=$_POST["giftcategory"];
			if($giftname=="")
			{
				cpmsg(lang('plugin/ychat','ychat_gifts_name_null'),'',"error");
			}
			else if($price=="")
			{
				cpmsg(lang('plugin/ychat','ychat_gifts_price_null'),'',"error");
			}
			else if(!is_numeric($price))
			{
				cpmsg(lang('plugin/ychat','ychat_gifts_price_isnumber'),'',"error");
			}
			else
			{
				$timeline=time();
				if($_FILES['pic']["type"])
				{
					$ext=strrchr($_FILES['pic']["name"],".");
					$iconpath='source/plugin/ychat/images/thumbnails/s'.$timeline.$ext;
					$dbiconpath='thumbnails/s'.$timeline.$ext;
					uploadfile($_FILES['pic'],$iconpath);
				}
				else
				{
					$dbiconpath=$_POST["pic"];
				}
				if(empty($dbiconpath))
				{
					cpmsg(lang('plugin/ychat','ychat_gifts_pic_null'),'',"error");
				}
				else
				{
					if($_FILES['picact']["type"])
					{
						$ext=strrchr($_FILES['picact']["name"],".");
						$diconpath='source/plugin/ychat/images/preview/d'.$timeline.$ext;
						$dbdiconpath='preview/d'.$timeline.$ext;
						uploadfile($_FILES['picact'],$diconpath);
					}
					else
					{
						$dbdiconpath=$_POST["picact"];
					}
					if(empty($dbdiconpath))
					{
						cpmsg(lang('plugin/ychat','ychat_gifts_picact_null'),'',"error");
					}
					else
					{
						
						$data=array(
							'cid'=>$giftcategory,
							'name'=>$giftname,
							'pic'=>$dbiconpath,
							'picAct'=>$dbdiconpath,
							'price'=>$price,
							'dateline'=>time(),
							);
						C::t("#ychat#ychat_gift_goods")->update($_GET["giftid"],$data);
						cpmsg(lang('plugin/ychat','ychat_gifts_edit_success'),'action=plugins&operation=config&identifier=ychat&pmod=ychat_admin_gift&ymod=list&page='.$_GET["page"],'succeed');
					}
				}
			}
		}
	}
	else if($ymod=="del")
	{
		$giftid=$_GET["giftid"];
		$result=C::t("#ychat#ychat_gift_goods")->delete($giftid);
		if($result)
		{
			cpmsg(lang('plugin/ychat','ychat_gifts_del_success'),'action=plugins&operation=config&identifier=ychat&pmod=ychat_admin_gift&ymod=list','succeed');
		}
		else
		{
			cpmsg(lang('plugin/ychat','ychat_gifts_del_error'),'action=plugins&operation=config&identifier=ychat&pmod=ychat_admin_gift&ymod=list','error');
		}
	}
function uploadfile($file,$path)
{
	if ((($file["type"] == "image/gif")|| ($file["type"] == "image/png")|| ($file["type"] == "image/jpeg")|| ($file["type"] == "image/pjpeg")||($file["type"]=="application/x-shockwave-flash"))
		&& ($file["size"] < 800000))
		{
		if ($file["error"] > 0)
		{
			cpmsg($file["error"],'',"error");
		}
		else
		{
			move_uploaded_file($file["tmp_name"],$path);
		}
  }
else
  {
	 cpmsg("ychat_hostresslevel_icon_upload_error",'',"error");
  }
}
?>