<?php
namespace Admin\Controller;
use Think\Controller;

class IndexController extends CommonController {

	public function index() {

		// 最大文章点击数量
		$news = D('News')->maxcount();
		
		// 文章总数量
		$newscount = D('News')->getNewsCount(array('status' => 1));

		// 推荐位数量
		$positioncount = D('Position')->getCount(array('status'=>1));

		// 今天登陆用户数
		$admincount = D('Admin')->getLastLoginUsers();

		$this->assign('news',$news);
		$this->assign('newscount',$newscount);
		$this->assign('positioncount',$positioncount);
		$this->assign('admincount',$admincount);
		$this->display();

	}
}
