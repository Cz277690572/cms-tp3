<?php
namespace Admin\Controller;
use Think\Controller;
use Think\Exception;

/**
* 用户管理 
*/
class AdminController extends CommonController {

	public function index() {
		$admins = D('Admin')->getAdmin();
		$this->assign('admins', $admins);
		$this->display();
	}

	// 添加
	public function add() {
		if(IS_POST) {

			if(!isset($_POST['username']) || !$_POST['username']) {
				return show(0, '用户名不能为空');
			}
			if(!isset($_POST['password']) || !$_POST['password']) {
				return show(0, '密码不能为空');
			}
			$_POST['password'] = getMd5Password($_POST['password']);
			// 判断用户名是否存在
			$admin = D('Admin')->getAdminByUsername($_POST['username']);
			if($admin) {
				return show(0, '该用户存在');
			}

			// 新增
			$id = D('Admin')->insert($_POST);
			if(!$id) {
				return show(0, '新增失败');
			}
			return show(1, '新增成功');
		}
		$this->display();
	}

	// 修改信息
	public function personal() {
		$admin_id = $_SESSION['adminUser']['admin_id'] ? $_SESSION['adminUser']['admin_id']: '';
		$user = D('Admin')->getAdminByUserId($admin_id);
		$this->assign('vo', $user);
		$this->display();
	}

	// 修改状态
	public function setStatus() {
		$data = $_POST;
		return parent::setStatus($data,'Admin');
	}

	// 保存
	public function save() {
		$admin_id = $_SESSION['adminUser']['admin_id'] ? $_SESSION['adminUser']['admin_id']: '';
		if(!$admin_id) {
			return show(0,'用户不存在');
		}

		$data['realname'] = $_POST['realname'];
		$data['email'] = $_POST['email'];
		try {
			$id = D('Admin')->updateByAdminId($admin_id,$data);
			if($id === false) {
				return show(0, '配置失败');
			}
			return show(1, '配置成功');
		}catch(Exception $e) {
			return $e->getMessage();
		}
	}

}
