<?php
namespace Admin\Controller;
use Think\Controller;
use Think\Exception;
class PositioncontentController extends CommonController {
	
	public function index() {

		$positions = D('Position')->getNormalPositions();
		// 获取推荐位里面的内容
		$data['status'] = array('neq', -1);
		if($_GET['title']) {
			$data['title'] = trim($_GET['title']);
			$this->assign('title', $data['title']);
			$data['title'] = array('like', '%'.$data['title'].'%');
		}
		if($_GET['position_id']) {
			$data['position_id'] = array('eq', $_GET['position_id']);
			$this->assign('positionId', $_GET['position_id']);
		}

		// 分页
		$page = $_REQUEST['p'] ? $_REQUEST['p'] : 1;
        $pageSize = $_REQUEST['pageSize'] ? $_REQUEST['pageSize'] : 2;
		$contents = D('PositionContent')->getPositionContent($data,$page,$pageSize);
		$contentsCount = D('PositionContent')->getPositionContentCount($data);

		$res = new \Think\Page($contentsCount, $pageSize);
		$pageRes = $res->show();
		$this->assign('pageRes', $pageRes);
		$this->assign('positions',$positions);
		$this->assign('contents',$contents);
		$this->display();
	}

	// 添加
	public function add() {

		if($_POST){
			if(!$_POST['title'] || !isset($_POST['title'])) {
				return show(0, '推荐位标题不存在');
			}
			if(!$_POST['position_id'] || !isset($_POST['position_id'])) {
				return show(0, '推荐位ID不合法');
			}
			if(!$_POST['url'] && !$_POST['news_id']) {
				return show(0, 'url和news_id不能同时为空');
			}
			if(!isset($_POST['thumb']) || !$_POST['thumb']) {
				// 绑定文章id，即不用再上传图片
				if($_POST['news_id']) {
					$res = D('News')->find($_POST['news_id']);
					if($res && is_array($res)) {
						$_POST['thumb'] = $res['thumb'];
					}
				}else {
					return show(0, '图片不能为空');
				}
			}
			// 修改
			if($_POST['id']) {
				return $this->save($_POST);
			}
			// 添加
			try{
				$id = D('PositionContent')->insert($_POST);
				if($id) {
					return show(1, '新增成功'); 
				}
				return show(0, '新增失败');
			}catch(Exception $e) {
				return show(0, $e->getMessage());
			}

		}else {

			$positions = D("Position")->getNormalPositions();
            $this->assign('positions', $positions);
            $this->display();
		}
	}

	// 修改推荐位内容
	public function save($data) {
		$id = $data['id'];
		unset($data['id']);

		try {
			$resId = D('PositionContent')->updateById($id, $data);
			if($resId === false) {
				return show(0, '更新失败');
			}
			return show(1, '更新成功');
		}catch(Exception $e) {
			return show(0, $e->getMessage);
		}
	}

	// 显示即时编辑页面
	public function edit() {
		$id = $_GET['id'];
		
		$position = D('PositionContent')->find($id);
		$positions = D('Position')->getNormalPositions();
		$this->assign('positions', $positions);
		$this->assign('vo', $position);
		$this->display();
	}

	// 修改推荐位内容状态
	public function setStatus() {
		$data = array(
			'id' => intval($_POST['id']),
			'status' => intval($_POST['status'])
		);
		return parent::setStatus($data, 'PositionContent');
	}

	// 更新排序
	public function listorder() {
		return parent::listorder('PositionContent');
	}
}