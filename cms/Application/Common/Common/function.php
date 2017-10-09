<?php

/**
 * 公共的方法
 */
function show($status, $message,$data=array()) {
	$result = array(
			'status' => $status,
			'message' => $message,
			'data' => $data,
		);
	exit(json_encode($result));
}

function getMd5Password($password) {
	return md5($password . C('MD5_PRE'));
}

// 后台首页输出管理员方法
function getLoginUsername() {
    return $_SESSION['adminUser']['username'] ? $_SESSION['adminUser']['username']: '';
}

// 后台输出菜单属性名
function getMenuType($type) {
	return $type == 1 ? '后台菜单' : '前端导航';
}
// 后台输出菜单状态
function status($status) {
	if($status == 0) {
		$str = '关闭';
	}elseif($status == 1){
		$str = '正常';
	}elseif($status == -1){
		$str = '删除';
	}
	return $str;
}
// 后台左侧菜单链接拼接
function getAdminMenuUrl($nav) {
	$url = '/admin.php?c='.$nav['c'].'&a='.$nav['a'];
	if($nav['f'] == 'index') {
		$url = '/admin.php?c='.$nav['c'];
	}
	return $url;
}
// 后台左侧菜单高亮显示链接
function getActive($navc) {
	// 获取当前控制器名字
	$c = strtolower(CONTROLLER_NAME);
	if(strtolower($navc) == $c) {
		return 'class="active"';
	}
	return '';
}

// 图片插件上传报错提示方法
function showKind($status,$data) {
	header('Content-type:application/json;charset=UTF-8');
	if($status == 0) {
		exit(json_encode(array('error'=>0,'url'=>$data)));
	}
	exit(json_encode(array('error'=>1,'message'=>'上传失败')));
}

// 获取文章栏目
function getCatName($webSiteMenu, $id) {
	foreach ($webSiteMenu as $value) {
		$navList[$value['menu_id']] = $value['name'];
	}
	return isset($navList[$id]) ? $navList[$id] : '';
}

// 获取文章来源
function getCopyFromById($id) {
	$copyFrom = C('COPY_FROM');
	return $copyFrom[$id] ? $copyFrom[$id] : '';
}

// 判断文章是否有缩略图
function isThumb($thumb) {
	if($thumb) {
		return '<span style="color:red">有</span>';
	}
	return '无';
}