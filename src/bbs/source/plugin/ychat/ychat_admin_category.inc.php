<?php

if(!defined('IN_DISCUZ')) {
   exit('Access Deined');
}
cpheader();
$_GET=daddslashes($_GET);
$_POST=daddslashes($_POST);
$ymod = empty($_GET['ymod']) ? 'list' : $_GET['ymod'];
$fid = getgpc('fid');

if($ymod == 'list') {
	if(!submitcheck('editsubmit')) {
		require_once libfile('function/forumlist');
		$forums = str_replace("'", "\'", forumselect(false, 0, 0, 1));

?>
<script type="text/JavaScript">
var forumselect = '<?php echo $forums;?>';
var rowtypedata = [
	[[1, ''], [1,'', 'td25'], [5, '<div><input name="newcat[]" value="<?php cplang('da lei', null, true);?>" size="20" type="text" class="txt" /><a href="javascript:;" class="deleterow" onClick="deleterow(this)"><?php cplang('delete', null, true);?></a></div>']],
	[[1, ''], [1,'', 'td25'], [5, '<div class="board"><input name="newforum[{1}][]" value="<?php cplang('xiao lei', null, true);?>" size="20" type="text" class="txt" /><a href="javascript:;" class="deleterow" onClick="deleterow(this)"><?php cplang('delete', null, true);?></a></div>']],
];
</script>
<?php
		showformheader('plugins&operation=config&identifier=ychat&pmod=ychat_admin_category');
		echo '<div style="height:30px;line-height:30px;"><a href="javascript:;" onclick="show_all()">'.cplang('show_all').'</a> | <a href="javascript:;" onclick="hide_all()">'.cplang('hide_all').'</a> </div>';
		showtableheader('');
		showsubtitle(array('', lang('plugin/ychat','ychat_categoryID'), lang('plugin/ychat','ychat_categoryName'), '',  $lang['edit']));
		$bcategoryarr=C::t("#ychat#ychat_bcategory")->fetch_all();
		foreach($bcategoryarr as $bvalue)
		{
			
			$showed[] = showCategory($bvalue, '');
			$categoryarr=C::t("#ychat#ychat_category")->fetch_all_by_bcategoryid($bvalue["bCategoryID"]);
			echo '<tbody id="group_'.$bvalue["bCategoryID"].'">';
			foreach($categoryarr as $value)
			{
				$showed[] = showCategory($value, 'sub',$bvalue["bCategoryID"]);
			}
			
			showforum('lastboard','sub',$bvalue["bCategoryID"]);
			
		}
		

		showforum('last');

		showsubmit('editsubmit');
		showtablefooter();
		showformfooter();
	}
	else
	{		
		if(is_array($_GET['newcat'])) {
			foreach($_GET['newcat'] as $fid => $value) {
				C::t("#ychat#ychat_bcategory")->insert(array('bCategoryName'=>$_GET['newcat'][$fid]),0,1);
			}
		}
		if(is_array($_GET['newforum'])) {
			foreach($_GET['newforum'] as $upid => $upvalue) {
				foreach($_GET['newforum'][$upid] as $fid => $value) {
					C::t("#ychat#ychat_category")->insert(array('categoryName'=>$_GET['newforum'][$upid][$fid],'bCategoryID'=>$upid),0,1);
				}
			}
		}
		if(is_array($_GET['bname'])) {
			foreach($_GET['bname'] as $fid => $value) {
				C::t("#ychat#ychat_bcategory")->update($fid,array('bCategoryName'=>$_GET['bname'][$fid]));
			}
		}
		if(is_array($_GET['name'])) {
			foreach($_GET['name'] as $fid => $value) {
				
				C::t("#ychat#ychat_category")->update($fid,array('categoryName'=>$_GET['name'][$fid]));
			}
		}
		cpmsg(lang('plugin/ychat','ychatduo_category_edit_success'),'action=plugins&operation=config&identifier=ychat&pmod=ychat_admin_category','succeed');
	}
}
else if($ymod=="delete")
{
	C::t("#ychat#ychat_category")->delete($_GET['cid']);
	C::t("#ychat#ychat_rooms")->delete_category_by_id($_GET['cid']);
	cpmsg(lang('plugin/ychat','ychatduo_category_del_success'),'action=plugins&operation=config&identifier=ychat&pmod=ychat_admin_category','succeed');
}
else if($ymod=="bdelete")
{
	$bcatearr=C::t("#ychat#ychat_category")->fetch_all_by_bcategoryid($_GET['cid']);
	foreach($bcatearr as $value);
	if($value)
	{
		cpmsg(lang('plugin/ychat','ychat_delete_category_fail'),'','error');
	}
	else
	{
		C::t("#ychat#ychat_bcategory")->delete($_GET['cid']);
		cpmsg(lang('plugin/ychat','ychatduo_category_del_success'),'action=plugins&operation=config&identifier=ychat&pmod=ychat_admin_category','succeed');
	
	}
}
function showCategory(&$category, $type = '',$upCategoryID) {

	if($type=='')
	{
		echo '<tr class="hover">
	<td class="td25" onclick="toggle_group(\'group_'.$category["bCategoryID"].'\', $(\'a_group_'.$category["bCategoryID"].'\'))"><a href="javascript:;" id="a_group_'.$category["bCategoryID"].'">[-]</a></td>
	<td class="td25">'.$category["bCategoryID"].'</td>
	<td><div class="parentboard"><input type="text" name="bname['.$category["bCategoryID"].']" value="'.$category["bCategoryName"].'" class="txt" /></div></td><td></td>
	<td width="160"><a href="admin.php?action=plugins&operation=config&identifier=ychat&pmod=ychat_admin_category&ymod=bdelete&cid='.$category["bCategoryID"].'" title="删除类别及其中所有房间" class="act">删除</a></td>
	</tr>';
	}
	else 
	{
		echo '
		<tr class="hover">
		<td class="td25"></td>
		<td class="td25">'.$category["categoryID"].'</td>
		<td><div class="board"><input type="text" name="name['.$category["categoryID"].']" value="'.$category["categoryName"].'" class="txt" /></div></td><td></td>
		<td width="160"><a href="admin.php?action=plugins&operation=config&identifier=ychat&pmod=ychat_admin_category&ymod=delete&cid='.$category["categoryID"].'" title="删除类别及其中所有房间" class="act">删除</a></td>
		</tr>
		';
	}
}	
function showforum($last,$type='',$upCategoryID)
{
	if($last == 'lastboard') {
			$return = '</tbody><tr><td></td><td colspan="4"><div class="lastboard"><a href="###" onclick="addrow(this, 1, '.$upCategoryID.')" class="addtr">'.cplang('forums_admin_add_forum').'</a></div></td><td>&nbsp;</td></tr>';
		}elseif($last == 'last') {
			$return = '</tbody><tr><td></td><td colspan="4"><div><a href="###" onclick="addrow(this, 0)" class="addtr">'.cplang('forums_admin_add_category').'</a></div></td>'.
				'<td class="bold"></td>'.
				'</tr>';
		}
	echo $return;
}

?>