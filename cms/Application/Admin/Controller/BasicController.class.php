<?php
namespace Admin\Controller;
use Think\Controller;

class BasicController extends CommonController {
	public function index() {
		$result = D('Basic')->select();
		$this->assign('vo', $result);
		$this->assign('type', 1);
		$this->display();
	}

	public function add() {
		if(IS_POST){
			
			if(!$_POST['title']) {
				return show(0, '标题不能为空');
			}
			if(!$_POST['keywords']) {
				return show(0, '关键字不能为空');
			}
			if(!$_POST['description']) {
				return show(0, '关键字不能为空');
			}
			D('Basic')->save($_POST);

			return show(1, '配置成功');
		}else {
			return show(0, '没有提交的数据');
		}
	}

	/**
	 * 缓存管理
	 */
	public function cache() {
		$this->assign('type', 2);
		$this->display();
	}

	/**
	 * 数据库管理
	 */
	public function dumpmysql() {
		$this->assign('type', 3);
		$this->display();
	}

	/**
	 * 数据库备份(此功能失效)
	 */
	public function beifen_mysql() {

		$shell = "mysqldump -u".C("DB_USER")." " .C("DB_NAME")." > ./cms".date("Ymd").".sql";
        exec($shell);
		return show(1, "数据库备份成功");
	}
}