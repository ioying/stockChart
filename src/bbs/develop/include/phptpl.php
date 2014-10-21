<?php
/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: phptpl.php 30694 2012-06-12 09:26:01Z zhengqingpeng $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
$tplyear = dgmdate(TIMESTAMP, 'Y');
$nowdate = dgmdate(TIMESTAMP);
$phptpl['emptyfile'] = <<<EOF
<?php
/**
 *	[$plugin[name]($plugin[identifier].{modulename})] (C)$tplyear-2099 Powered by $plugin[copyright].
 *	Version: $plugin[version]
 *	Date: $nowdate
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
//==={code}===
?>
EOF;

$phptpl['baseclass'] = <<<EOF
class plugin_{modulename} {
	//TODO - Insert your code here
//==={code}===
}

EOF;

$phptpl['extendclass'] = <<<EOF

class plugin_{modulename}_{curscript} extends plugin_{modulename} {
	//TODO - Insert your code here
//==={code}===
}

EOF;

$phptpl['specialclass'] = <<<EOF

class threadplugin_$plugin[identifier] {

	public \$name = 'XX����';			//������������
	public \$iconfile = 'icon.gif';	//�������������е�ǰ׺ͼ��
	public \$buttontext = '����xx����';	//����ʱ��ť����

	/**
	 * ������ʱҳ�������ı���Ŀ
	 * @param Integer \$fid: ���ID
	 * @return string ͨ�� return ���ؼ������������ҳ���� 
	 */
	public function newthread(\$fid) {
		//TODO - Insert your code here
		
		return 'TODO:newthread';
	}

	/**
	 * ���ⷢ��ǰ�������ж� 
	 * @param Integer \$fid: ���ID
	 */
	public function newthread_submit(\$fid) {
		//TODO - Insert your code here
		
	}

	/**
	 * ���ⷢ��������ݴ��� 
	 * @param Integer \$fid: ���ID
	 * @param Integer \$tid: ��ǰ����ID
	 */
	public function newthread_submit_end(\$fid, \$tid) {
		//TODO - Insert your code here
		
	}

	/**
	 * �༭����ʱҳ�������ı���Ŀ
	 * @param Integer \$fid: ���ID
	 * @param Integer \$tid: ��ǰ����ID
	 * @return string ͨ�� return ���ؼ���������༭����ҳ���� 
	 */
	public function editpost(\$fid, \$tid) {
		//TODO - Insert your code here
		
		return 'TODO:editpost';
	}

	/**
	 * ����༭ǰ�������ж� 
	 * @param Integer \$fid: ���ID
	 * @param Integer \$tid: ��ǰ����ID
	 */
	public function editpost_submit(\$fid, \$tid) {
		//TODO - Insert your code here
		
	}

	/**
	 * ����༭������ݴ��� 
	 * @param Integer \$fid: ���ID
	 * @param Integer \$tid: ��ǰ����ID
	 */
	public function editpost_submit_end(\$fid, \$tid) {
		//TODO - Insert your code here
		
	}

	/**
	 * ����������ݴ��� 
	 * @param Integer \$fid: ���ID
	 * @param Integer \$tid: ��ǰ����ID
	 */
	public function newreply_submit_end(\$fid, \$tid) {
		//TODO - Insert your code here
		
	}

	/**
	 * �鿴����ʱҳ������������
	 * @param Integer \$tid: ��ǰ����ID
	 * @return string ͨ�� return ���ؼ����������������ҳ����
	 */
	public function viewthread(\$tid) {
		//TODO - Insert your code here
		
		return 'TODO:viewthread';
	}
}

EOF;

$phptpl['methodtpl'] = <<<EOF
	/**
	 * @Methods describe
	 * @return {returncomment} type
	 */
	public function {methodName}() {
		//TODO - Insert your code here
		
		return {return};	//TODO modify your return code here
	}

EOF;

$phptpl['magic'] = <<<EOF
class magic_{name} {
	public \$version = '$plugin[version]';	//�ű��汾��
	public \$name = '{name}';				//�������� (����д���԰���Ŀ)
	public \$description = '{desc}';		//����˵�� (����д���԰���Ŀ)
	public \$price = '20';	//����Ĭ�ϼ۸�
	public \$weight = '20';	//����Ĭ������
	public \$useevent = 0;
	public \$targetgroupperm = false;
	public \$copyright = '<a href="http://www.comsenz.com" target="_blank">Comsenz Inc.</a>';	//��Ȩ (����д���԰���Ŀ)
	public \$magic = array();
	public \$parameters = array();

	/**
	 * ����������Ŀ
	 */
	public function getsetting(&\$magic) {
		//TODO - Insert your code here
	}

	/**
	 * ����������Ŀ
	 */
	public function setsetting(&\$magicnew, &\$parameters) {
		//TODO - Insert your code here
	}

	/**
	 * ����ʹ��
	 */
	public function usesubmit() {
		//TODO - Insert your code here
	}

	/**
	 * ������ʾ
	 */
	public function show() {
		//TODO - Insert your code here
	}
}
EOF;
$phptpl['cron'] = <<<EOF
<?php
/**
 *	[$plugin[name]($plugin[identifier].{modulename})] (C)$tplyear-2099 Powered by $plugin[copyright].
 *	Version: $plugin[version]
 *	Date: $nowdate
 *	Warning: Don't delete this comment
 *
 *	cronname:{name}
 *	week:{weekday}
 *	day:{day}
 *	hour:{hour}
 *	minute:{minute}
 *	desc:{desc}
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

//TODO - Insert your code here
?>

EOF;
$phptpl['adv'] = <<<EOF
class adv_{name} {

	public \$version = '$plugin[version]';	//�ű��汾��
	public \$name = '{name}';				//����������� (����д���԰���Ŀ)
	public \$description = '{desc}';		//�������˵�� (����д���԰���Ŀ)
	public \$copyright = '<a href="http://www.comsenz.com" target="_blank">Comsenz Inc.</a>';	//��Ȩ (����д���԰���Ŀ)
	public \$targets = array('portal', 'home', 'member', 'forum', 'group', 'userapp', 'plugin', 'custom');	//����������õ�Ͷ�ŷ�Χ
	public \$imagesizes = array();	//���������array('468x60', '658x60', '728x90', '760x90', '950x90')

	/**
	 * ����������Ŀ
	 */
	public function getsetting() {
		//TODO - Insert your code here
	}

	/**
	 * ����������Ŀ
	 */
	public function setsetting(&\$advnew, &\$parameters) {
		//TODO - Insert your code here
	}

	/**
	 * �����ʾʱ�����д���
	 */
	public function evalcode() {
		//TODO - Insert your code here
	}

}
EOF;
$phptpl['task'] = <<<EOF
class task_{name} {

	public \$version = '$plugin[version]';	//�ű��汾��
	public \$name = '{name}';	//�������� (����д���԰���Ŀ)
	public \$description = '{desc}';	//����˵�� (����д���԰���Ŀ)
	public \$copyright = '<a href="http://www.comsenz.com" target="_blank">Comsenz Inc.</a>';	//��Ȩ (����д���԰���Ŀ)
	public \$icon = '';		//Ĭ��ͼ��
	public \$period = '';	//Ĭ������������
	public \$periodtype = 0;//Ĭ�����������ڵ�λ
	public \$conditions = array();	//���񸽼�����

	/**
	 * ��������ɹ���ĸ��Ӵ���
	 */
	public function  preprocess(\$task) {
		//TODO - Insert your code here
	}

	/**
	 * �ж������Ƿ���� (���� TRUE:�ɹ� FALSE:ʧ�� 0:��������н���δ֪����δ��ʼ  ����0������:��������з����������)
	 */
	public function csc(\$task = array()) {
		//TODO - Insert your code here
	}

	/**
	 * ��������ĸ��Ӵ���
	 */
	public function sufprocess(\$task) {
		//TODO - Insert your code here
	}

	/**
	 * ������ʾ
	 */
	public function view() {
		//TODO - Insert your code here
	}

	/**
	 * ����װ�ĸ��Ӵ���
	 */
	public function install() {
		//TODO - Insert your code here
	}

	/**
	 * ����ж�صĸ��Ӵ���
	 */
	public function uninstall() {
		//TODO - Insert your code here
	}

	/**
	 * ���������ĸ��Ӵ���
	 */
	public function upgrade() {
		//TODO - Insert your code here
	}
}
EOF;
$phptpl['secqaa'] = <<<EOF
class secqaa_{name} {

	public \$version = '$plugin[version]';	//�ű��汾��
	public \$name = '{name}';	//��֤�ʴ����� (����д���԰���Ŀ)
	public \$description = '{desc}';	//��֤�ʴ�˵�� (����д���԰���Ŀ)
	public \$copyright = '<a href="http://www.comsenz.com" target="_blank">Comsenz Inc.</a>';	//��Ȩ (����д���԰���Ŀ)
	public \$customname = '';

	/**
	 * ���ذ�ȫ�ʴ�Ĵ𰸺����� (\$question Ϊ���⣬��������ֵΪ��)
	 */
	public function make(&\$question) {
		//TODO - Insert your code here
	}
}
EOF;
$phptpl['seccode'] = <<<EOF
class seccode_{name} {

	public \$version = '$plugin[version]';
	public \$name = '{name}';
	public \$description = '{desc}';
	public \$copyright = '<a href="http://www.comsenz.com" target="_blank">Comsenz Inc.</a>';
	public \$customname = '';

	/**
	 * ����������֤�룬���� true ��ʾͨ��
	 */
	public function check(\$value, \$idhash) {
		//TODO - Insert your code here
	}

	/**
	 * �����֤�룬echo ������ݽ���ʾ��ҳ����
	 */
	public function make() {
		//TODO - Insert your code here
	}
}
EOF;
$phptpl['sqlcode'] = <<<EOFSQL

\$sql = <<<EOF
{sql}
EOF;

runquery(\$sql);
\$finish = true;
EOFSQL;
?>