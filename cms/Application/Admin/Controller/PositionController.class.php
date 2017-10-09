<?php
namespace Admin\Controller;
use Think\Controller;

class PositionController extends CommonController {

	public function index() {

		$position = D('Position')->getNormalPositions();
		$this->assign('positions',$position);
		$this->display();
	}

	public function add() {

		if($_POST){
			if(!$_POST['name'] || !isset($_POST['name'])) {
				return show(0,'推荐位名称不能为空');
			}

			// 存在id则表示及时编辑
			if($_POST['id']) {
				return $this->save($_POST);
			}
			try {
				$id = D('Position')->insert($_POST);
				if($id) {
					return show(1, '新增成功', $id);
				}
				return show(0, '新增失败', $id);
			}catch(Exception $e) {
				return show(0, $e->getMessage());
			}
			return show(0, '新增失败', $newsId);
		}else{
			$this->display();
		}

	}

	// 编辑页面
	public function edit() {
		$id = $_GET['id'];
		$position = D('Position')->find($id);
		$this->assign('vo',$position);
		$this->display();
	}

	// 更新
	public function save($data = array()) {
		$id = $data['id'];
		unset($data['id']);
		try {
			$id = D('Position')->updateById($id,$data);
			if($id === false) {
				return show(0,'更新失败');
			}
			return show(1,'更新成功');
		}catch (Exception $e) {
			return show(0,$e->getMessage());
		}
	}

	// 设置状态
	public function setStatus() {
		$data = array(
			'id' => intval($_POST['id']),
			'status' => intval($_POST['status'])
		);
		return parent::setStatus($data, 'Position');
	}


}