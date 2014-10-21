<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: plugin.lang.php 30542 2012-06-01 08:03:33Z zhengqingpeng $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}


$devlang = array
(
	//note ������	���� plugins_ ��ͷ
	'author' => '����',
	'add_new' => '����',
	//note �û������	���� usergroups_ ��ͷ
	'usergroups' => '�û���',
	'usergroups_system_0' => '��ͨ�û�',
	'usergroups_system_1' => '����Ա',
	'usergroups_system_2' => '��������',
	'usergroups_system_3' => '����',
	'usergroups_system_4' => '��ֹ����',
	'usergroups_system_5' => '��ֹ����',
	'usergroups_system_6' => '�û�IP����ֹ',
	'usergroups_system_7' => '�ο�',
	'usergroups_system_8' => '�ȴ���֤',
	'plugins' => '�������',
	'plugins_home' => '����',
	'plugins_editlink' => '���',
	'plugins_validator' => '������',
	'plugins_list' => '����б�',
	'plugins_system' => 'ϵͳ���',
	'plugins_install' => '��װ�²��',
	'plugins_newcomment' => '����Ϊ���Ŀ¼ source/plugin/ ��δ��װ�Ĳ��',
	'plugins_menu' => '���',
	'plugins_name' => '�������',
	'plugins_unavailable' => '�����δ������',
	'plugins_empty' => '��',
	'plugins_directory' => '���Ŀ¼',
	'plugins_identifier' => 'Ψһ��ʶ��',
	'plugins_vars_title' => '��������(����)',
	'plugins_vars_variable' => '���ñ�����(����)',
	'plugins_vars_type' => '��������',
	'plugins_add' => '����²��',
	'plugins_add_tips' => '<li><b>�����ܽ������������ʹ�á�</b></li><li>���������Ա��ʹ�ñ�����ǰ�������ϸ�Ķ���<a href="http://dev.discuz.org/wiki" target="_blank">Discuz! �����Ŀ�</a>���е����ݡ�</li><li>����: ����ȷ�Ĳ����ƻ�װ����Σ��������վ�������ʹ�á�</li>',
	'plugins_import' => '����������',
	'plugins_import_ignore_version' => '���������ϰ汾 Discuz! �Ĳ��(�ײ�������!!)',
	'plugins_update_to' => '���µ� ',
	'plugins_config' => '��������',
	'plugins_config_module' => 'ģ��',
	'plugins_config_vars' => '����',
	'plugins_config_install' => '��װ',
	'plugins_config_uninstall' => 'ж��',
	'plugins_config_upgrade' => '����',
	'plugins_config_delete' => 'ж��',
	'plugins_config_upgrade_other' => '��ȷ��Ҫ�� {pluginname} {version} ������µ����°汾��',
	'plugins_config_uninstallplugin' => 'ж�ش˲��',
	'plugins_edit' => '��Ʋ��',
	'plugins_edit_available' => ' (���������)',
	'plugins_edit_tips' => '<li><b>�����ܽ������������ʹ�ã������ֻ�ǰ�װ��ʹ�ñ�����������޸ı����á�</b></li><li>���������Ա��ʹ�ñ�����ǰ�������ϸ�Ķ���<a href="http://dev.discuz.org/wiki" target="_blank">Discuz! �����Ŀ�</a>���е����ݡ�</li><li>����: ����ȷ�Ĳ����ƻ�װ����Σ��������վ�������ʹ�á�</li><li>�������Ĳ��������<a href="http://addon.discuz.com" target="_blank">��Discuz! Ӧ�����ġ�</a>���������վ����</li>',
	'plugins_edit_name' => '�������(name)',
	'plugins_edit_name_comment' => '�˲�������ƣ���Ӣ�ľ��ɣ���� 40 ���ֽ�',
	'plugins_edit_version' => '����汾��(version)',
	'plugins_edit_version_comment' => '�˲���İ汾����Ӣ�ľ��ɣ���� 20 ���ֽڡ��汾�Ÿ��ھɰ汾��ʱ����װ���û�ʱ������ʾ����',
	'plugins_edit_copyright' => '��Ȩ��Ϣ(copyright)',
	'plugins_edit_copyright_comment' => '���ò���İ�Ȩ��Ϣ����� 100 ���ֽڣ�һ�������޷�����',
	'plugins_edit_identifier' => 'Ψһ��ʶ��(identifier)',
	'plugins_edit_identifier_comment' => '�����ΨһӢ�ı�ʶ�����ܹ������в����ʶ�ظ�����ʹ����ĸ�����֡��»������������ܰ����������Ż������ַ������ 40 ���ֽ�',
	'plugins_edit_adminid' => '��̨Ȩ�޵ȼ�(adminid)',
	'plugins_edit_adminid_comment' => 'ʹ�ù��������в���ӿ��Դ��Ĳ���������ó�����������Ȩ�޵ȼ�Ҫ��ע��: ����ĺ�̨ģ��ӵ���Լ���Ȩ�����ã���˲��ܴ�����',
	'plugins_edit_directory' => '���Ŀ¼(directory)',
	'plugins_edit_directory_comment' => '�������(����ǰ̨�ͺ�̨)����� source/plugin/ �����·���������� "/" ��β�������������������ָ�������ã���Ĭ�ϲ����ǰ��̨����������� source/plugin/ � ',
	'plugins_edit_description' => '�������(description)',
	'plugins_edit_description_comment' => '����ļ���������� 100 ���ֽڣ���ѡ��',
	'plugins_edit_langexists' => '������԰�',
	'plugins_edit_langexists_comment' => '�������������԰�����ѡ���ǡ�',
	'plugins_edit_modules' => '���ģ��͵���',
	'plugins_edit_modules_name' => '����ģ��(����)',
	'plugins_edit_modules_menu' => '��������',
	'plugins_edit_modules_menu_url' => '���� URL',
	'plugins_edit_modules_navtitle' => '����˵��',
	'plugins_edit_modules_navicon' => '����ͼ��',
	'plugins_edit_modules_navsubname' => '����������',
	'plugins_edit_modules_navsuburl' => '����������',
	'plugins_edit_modules_type' => 'ģ������',
	'plugins_edit_modules_type_1' => '��������Ŀ',
	'plugins_edit_modules_type_2' => '',
	'plugins_edit_modules_type_5' => '��������Ŀ - ����˵�',
	'plugins_edit_modules_type_23' => '�ײ�������Ŀ',
	'plugins_edit_modules_type_24' => '��԰������Ŀ',
	'plugins_edit_modules_type_25' => '��ݵ�����Ŀ',
	'plugins_edit_modules_type_6' => '',
	'plugins_edit_modules_type_7' => '��������',
	'plugins_edit_modules_type_8' => '',
	'plugins_edit_modules_type_9' => '',
	'plugins_edit_modules_type_10' => '',
	'plugins_edit_modules_type_3' => '��������',
	'plugins_edit_modules_type_4' => 'ȫ�ְ���',
	'plugins_edit_modules_type_11' => 'ҳ��Ƕ�� - ��ͨ��',
	'plugins_edit_modules_type_12' => '��������',
	'plugins_edit_modules_type_13' => '��ͨ�ű�',
	'plugins_edit_modules_type_14' => 'վ�����',
	'plugins_edit_modules_type_15' => '��̳���� - ����',
	'plugins_edit_modules_type_16' => '��̳���� - ����',
	'plugins_edit_modules_type_17' => '�������� - ��������',
	'plugins_edit_modules_type_19' => '�������� - ����',
	'plugins_edit_modules_type_18' => '',
	'plugins_edit_modules_type_21' => '�Ż�����',
	'plugins_edit_modules_type_26' => '�ҵ�����',
	'plugins_edit_modules_type_27' => '����������Ŀ',
	'plugins_edit_modules_type_28' => 'ҳ��Ƕ�� - �ֻ���',
	'plugins_edit_modules_type_g1' => '��������',
	'plugins_edit_modules_type_g2' => '����ű�',
	'plugins_edit_modules_type_g3' => '��չ��Ŀ',
	'plugins_edit_modules_adminid' => 'ʹ�õȼ�',
	'plugins_edit_modules_include' => '��������',
	'plugins_edit_vars' => '�����������',
	'plugins_edit_vars_title' => '��������',
	'plugins_edit_vars_title_comment' => '��Ӣ�ľ��ɣ�������ʾ�ڲ�����õĲ˵��У���� 100 ���ֽڡ��˴�֧�����Զ��壬���磺lang_admincp.php ������ \'myaction\'=>\'�ҵĲ���\' ����˴���д myaction ���ɣ����������ڶ����԰汾���������',
	'plugins_edit_vars_description' => '����˵��',
	'plugins_edit_vars_description_comment' => '�����������õ���;��ȡֵ��Χ����ϸ�����������ڲ��ʹ�����˽�������õ����ã���� 255 ���ֽڡ��˴��������������ƣ�Ҳ֧�����Զ���',
	'plugins_edit_vars_type' => '��������',
	'plugins_edit_vars_type_number' => '����(number)',
	'plugins_edit_vars_type_text' => '�ִ�(text)',
	'plugins_edit_vars_type_textarea' => '�ı�(textarea)',
	'plugins_edit_vars_type_radio' => '����(radio)',
	'plugins_edit_vars_type_select' => '��ѡѡ��(select)',
	'plugins_edit_vars_type_selects' => '����ѡ��(selects)',
	'plugins_edit_vars_type_color' => '��ɫ(color)',
	'plugins_edit_vars_type_date' => '����(date)',
	'plugins_edit_vars_type_datetime' => '����/ʱ��(datetime)',
	'plugins_edit_vars_type_forum' => '��鵥ѡ(forum)',
	'plugins_edit_vars_type_forums' => '����ѡ(forums)',
	'plugins_edit_vars_type_group' => '�û��鵥ѡ(group)',
	'plugins_edit_vars_type_groups' => '�û����ѡ(groups)',
	'plugins_edit_vars_type_extcredit' => '��չ����(extcredit)',
	'plugins_edit_vars_type_forum_text' => '���/�ִ�(forum_text)',
	'plugins_edit_vars_type_forum_textarea' => '���/�ı�(forum_textarea)',
	'plugins_edit_vars_type_forum_radio' => '���/����(forum_radio)',
	'plugins_edit_vars_type_forum_select' => '���/��ѡѡ��(forum_select)',
	'plugins_edit_vars_type_group_text' => '�û���/�ִ�(group_text)',
	'plugins_edit_vars_type_group_textarea' => '�û���/�ı�(group_textarea)',
	'plugins_edit_vars_type_group_radio' => '�û���/����(group_radio)',
	'plugins_edit_vars_type_group_select' => '�û���/��ѡѡ��(group_select)',
	'plugins_edit_vars_multiselect_comment' => '��ס CTRL ��ѡ',
	'plugins_edit_vars_type_comment' => '���ô����õ��������ͣ����ڳ����м��͹�����Ӧ����ֵ',
	'plugins_edit_vars_variable' => '���ñ�����',
	'plugins_edit_vars_variable_comment' => '����������Ŀ�ı����������ڲ�������е��ã��ɰ���Ӣ�ġ����ֺ��»��ߣ���ͬһ���������Ҫ���ֱ�������Ψһ�ԣ���� 40 ���ֽ�',
	'plugins_edit_vars_extra' => '��������',
	'plugins_edit_vars_extra_comment' => 'ֻ����������Ϊ��ѡ��(select)��ʱ��Ч�������趨ѡ��ֵ���Ⱥ�ǰ��Ϊѡ������(����������)������Ϊ���ݣ�����: <br /><i>1 = ������<br />2 = ��е���<br />3 = û�����</i><br />ע��: ѡ��ȷ���������޸����������ݵĶ�Ӧ��ϵ�����Կ�������ѡ����������ʾ˳�򣬿���ͨ���ƶ����е�����λ����ʵ��',
	'plugins_import_default' => 'Ĭ��',
	'plugins_import_installtype_1' => '���',
	'plugins_import_installtype_2' => '�ṩ������',
	'plugins_import_installtype_3' => '�ְ�װ��ʽ����ѡ��',
	'plugins_import_license' => '��ȨЭ��',
	'plugins_import_agree' => '��ͬ��',
	'plugins_import_pass' => '�Ҳ�ͬ��',
	'plugins_conflict_view' => '�鿴ϸ��',
	'plugins_conflict_info' => '��ϵ����',
	'plugins_module_sample' => '<span title="����ģ��ģ���ļ�">[&darr;]</span>',
	'plugins_find_newversion' => '�����°�',
	'plugins_online_update' => '������߰�װ�°�',
	'plugins_list_available' => '�����õĲ��',
	'plugins_list_unavailable' => 'δ���õĲ��',
	'plugins_list_new' => 'δ��װ�Ĳ��',
	'plugins_enable_succeed' => '���������',
	'plugin_not_found' => '���δ�ҵ�',
	'plugins_install_succeed' => '����ɹ���װ��<br />Ϊ������ʹ�ô˲���������ܻ���Ҫ�ϴ����޸���Ӧ���ļ���ģ�壬������鿴������İ�װ˵��<br /><br /><a href="http://addon.discuz.com?view=plugins">������ﷵ��Ӧ������</a><br />',
	'plugin_file_error' => '����ļ�ȱʧ',
	'plugins_edit_identifier_invalid' => '�������Ψһ��ʶ�����Ϸ��������в���ظ�',
	'plugins_upgrade_succeed' => '����ɹ����µ� {toversion}<br /><br /><a href="http://addon.discuz.com?view=plugins">������ﷵ��Ӧ������</a><br />',
	'plugins_edit_name_invalid' => '��û������������',
	'plugins_edit_succeed' => '������ø��³ɹ� ',
	'plugins_delete_succeed' => '����ɹ�ж�أ�<br />Ϊ������ж�ش˲���������ܻ���Ҫɾ�����޸���Ӧ���ļ���ģ�壬������鿴������İ�װ˵��',
	'plugins_conflict' => '���������</h4><br />������ʾ���������õĲ����ĳЩ������ڹ��õ�Ƕ��㡣��Ȼ����Ƕ�����������������������������������в�����������뼰ʱ��ϵ������ߡ�<a href="javascript:;" onclick="display(\'conflict\')">[����鿴]</a><br /><div id="conflict" style="display:none"><br />{plugins}<br /></div><br />',
	'plugins_disable_succeed' => '����ѹر�',
	'plugins_import_var_invalid' => '�����Ƕ������Ʋ��Ϸ����޷�����',
	'plugins_import_identifier_duplicated' => '��Ҫ����Ĳ��({plugin_name})�Ѿ���װ',
	'plugins_import_version_invalid_confirm' => '����������� Discuz! {cur_version} �뵱ǰ�汾({set_version})��һ�£���ȷ��Ҫ��װ��<br />���������İ�װ˵���в������޸��ļ���������˵���˲��Ϊ��ɫ��������ɷ��İ�װ',
	'plugins_import_version_invalid' => '����������� Discuz! {cur_version} �뵱ǰ�汾({set_version})��һ��',
	'plugins_import_succeed' => '������ݵ���ɹ���<br />Ϊ������ʹ�ô˲���������ܻ���Ҫ�ϴ����޸���Ӧ���ļ���ģ�壬������鿴������İ�װ˵��',
	'plugins_config_upgrade_confirm' => '��ȷ��Ҫ�� {pluginname} {version} ������µ� {toversion} ��',
	'plugins_config_upgrade_missed' => '�˲���Ѹ��µ����°汾<br /><br /><a href="http://addon.discuz.com?view=plugins">������ﷵ��Ӧ������</a><br />',
	'plugins_upgrade_var_invalid' => '�����Ƕ������Ʋ��Ϸ����޷�����',
	'plugins_setting_succeed' => '����������ø��³ɹ� ',
	'plugins_setting_module_nonexistence' => 'ָ���Ĳ������ģ���ļ�({modfile})�����ڻ�����﷨���������Ƿ��ѽ���������ϴ�',
	'plugins_add_succeed' => '����ѳɹ����ӣ������������ϸ����',
	'plugins_nonexistence' => '���������еĲ�������Ʋ��������ѡ������',
	'plugin_donot_edit' => '�������༭',
	'plugins_edit_directory_invalid' => '������Ĳ��Ŀ¼���Ϸ���û��ʹ�� "/" ��β',
	'plugins_edit_language_invalid' => '������԰��ļ�({langfile})������',
	'plugins_edit_modules_name_invalid' => '������ĳ���ģ�����Ʋ��Ϸ�',
	'plugins_edit_modules_duplicated' => '������ĳ���ģ������������ģ���ظ�',
	'plugins_edit_var_invalid' => '����������ñ��������Ϸ����ظ�',
	'plugins_delete_error' => '������ж��ϵͳ�����',
	'plugins_delete_confirm' => '��ȷ��Ҫж�� {pluginname} {toversion} �����<br /><br />��ѡ����ж�ظ�Ӧ�õ�ԭ���Ա������Ժ�Ϊ���ṩ���õ�Ӧ�ã�<br /><br /><label><input name="uninstallreason[]" class="checkbox" type="checkbox" value="1" />���ܲ���������</label> <label><input name="uninstallreason[]" class="checkbox" type="checkbox" value="2" />���治����</label> <label><input name="uninstallreason[]" class="checkbox" type="checkbox" value="3" />Ч�����������ٶ���</label> <label><input name="uninstallreason[]" class="checkbox" type="checkbox" value="4" />�����˸��õ�Ӧ��</label><label><input name="uninstallreason[]" class="checkbox" type="checkbox" value="5" />����������ж��</label>',
	'styles_delete_confirm' => '��ȷ��Ҫж����Щ�����<br /><br />��ѡ����ж�ظ�Ӧ�õ�ԭ���Ա������Ժ�Ϊ���ṩ���õ�Ӧ�ã�<br /><br /><label><input name="uninstallreason[]" class="checkbox" type="checkbox" value="1" />���ܲ���������</label> <label><input name="uninstallreason[]" class="checkbox" type="checkbox" value="2" />���治����</label> <label><input name="uninstallreason[]" class="checkbox" type="checkbox" value="3" />Ч�����������ٶ���</label> <label><input name="uninstallreason[]" class="checkbox" type="checkbox" value="4" />�����˸��õ�Ӧ��</label><label><input name="uninstallreason[]" class="checkbox" type="checkbox" value="5" />����������ж��</label>',
	'pluginvar_not_found' => '�������δ�ҵ�',
	'plugins_edit_var_title_invalid' => '��û��������������',
	'plugins_edit_vars_succeed' => '����������ø��³ɹ� ',
	'plugins_edit_vars_invalid' => '������ñ��������Ϸ������ѱ�ռ��',
	'plugins_validator_noupdate' => 'û�м�⵽�°汾���',
	'plugins_script_magic' => '���߽ű�',
	'plugins_script_cron' => '�ƻ�����ű�',
	'plugins_script_adv' => '���ű�',
	'plugins_script_task' => 'վ������ű�',
	'plugins_script_secqaa' => '��֤�ʴ�ű�',
	'plugins_script_seccode' => '��֤��ű�',
	'plugins_script_navigation' => '������ĿǶ��ű�',
	'plugins_script_repeat' => '�ļ������ظ�',
	'plugins_script_add' => '����',
	'plugins_script_delete' => 'ɾ��',
	);
?>