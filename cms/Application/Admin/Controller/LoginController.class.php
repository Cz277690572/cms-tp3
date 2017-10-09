<?php
namespace Admin\Controller;
use Think\Controller;

/**
 * use Common\Model Common\Common这块可以不需要使用，框架默认会加载Common里面的所有内容
 */

class LoginController extends Controller {
    public function index(){
        // 判断是否已经登录
    	if(session('adminUser')){
    		$this->redirect('Index/index');
    	}
        $this->display();

    }

    /**
     * 登录校验与登录时间更新
     */
    public function check() {
    	$username = I('post.username');
    	$password = I('post.password');
    	if(!trim($username)) {
    		return show(0,'用户名不能为空！');
    	}
    	if(!trim($password)) {
    		return show(0,'密码不能为空！');
    	}
    	// 用户&密码验证
    	$ret = D('Admin')->getAdminByUsername($username);
    	if(!$ret || $ret['status'] != 1) {
    		return show(0,'该用户不存在');
    	}
    	if($ret['password'] != getMd5Password($password)) {
    		return show(0, '密码错误');
    	}

    	D("Admin")->updateByAdminId($ret['admin_id'],array('lastlogintime'=>time()));

    	session('adminUser', $ret);
    	return show(1, '登录成功');
    }

    /**
     * 退出登录
     */
    public function loginout() {
    	session('adminUser', null);
    	$this->redirect('index');
    }
}