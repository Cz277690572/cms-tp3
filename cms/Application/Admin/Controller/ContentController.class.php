<?php
namespace Admin\Controller;
use Think\Controller;
use Think\Exception;

/**
 * 文章内容管理
 */
class ContentController extends CommonController {
	public function index() {
		$conds = array();
		$title = $_GET['title'];
		if($title) {
			$conds['title'] = $title;
			$this->assign('title',$conds['title']);
		}
		$catid = $_GET['catid'];
		if($catid) {
			$conds['catid'] = $catid;
			$this->assign('catid',$conds['catid']);
		}

		$page = $_REQUEST['p'] ? $_REQUEST['p'] : 1;
		$pageSize = 3;

		$news = D('News')->getNews($conds,$page,$pageSize);
		$count = D('News')->getNewsCount($conds);

		$res = new \Think\Page($count,$pageSize);
		$pageres = $res->show();

		$this->assign('pageres',$pageres);
		$this->assign('news',$news);
		$this->assign('webSiteMenu',D('Menu')->getBarMenus());
		$this->assign('positions',D('Position')->getNormalPositions());
		$this->display();
	}

	public function add() {

		if($_POST) {
			if(!isset($_POST['title']) || !$_POST['title']) {
				return show(0,'标题不存在');
			}
			if(!isset($_POST['small_title']) || !$_POST['small_title']) {
				return show(0,'短标题不存在');
			}
			if(!isset($_POST['catid']) || !$_POST['catid']) {
				return show(0,'文章栏目不存在');
			}
			if(!isset($_POST['keywords']) || !$_POST['keywords']) {
				return show(0,'关键字不存在');
			}
			if(!isset($_POST['content']) || !$_POST['content']) {
				return show(0,'内容不存在');
			}

			// 如果有id传过来则表示修改
			if($_POST['news_id']) {
				return $this->save($_POST);
			}

			// 没有id传过来则表示插入
			$newsId = D('News')->insert($_POST);
			if($newsId) {
				$newsContentData['content'] = $_POST['content'];
				$newsContentData['news_id'] = $newsId;
				$cId = D('NewsContent')->insert($newsContentData);
				if($cId){
					return show(1,'新增成功');
				}else{
					return show(0,'主表插入成功，副表新增失败');
				}
			}else{
				return show(0,'新增失败');
			}

		}else {

			$webSiteMenu = D("Menu")->getBarMenus();

            $titleFontColor = C("TITLE_FONT_COLOR");
            $copyFrom = C("COPY_FROM");
            $this->assign('webSiteMenu', $webSiteMenu);
            $this->assign('titleFontColor', $titleFontColor);
            $this->assign('copyfrom', $copyFrom);
            $this->display();
		}
	}

	public function save($data) {
		$newsId = $data['news_id'];
		unset($data['news_id']);

		try{ 
			$id = D('News')->updateById($newsId, $data);
			$newsContentData['content'] = $data['content'];
			$condId = D('NewsContent')->updateNewsById($newsId, $newsContentData);
			if($id === false || $condId === false) {
				return show(0, '更新失败');
			}
			return show(1, '更新成功');
		}catch(Exception $e){
			return show(0, $e->getMessage());
		}

	}

	public function edit() {
		$newsId = $_GET['id'];
		if(!$newsId) {
			// 执行跳转
			$this->redirect('/admin.php?c=content');
		}
		$news = '';
		$news = D('News')->find($newsId);

		if(!$news) {
			$this->redirect('/admin.php?c=content');
		}
		$newsContent = D('NewsContent')->find($newsId);
		if($newsContent) {
			$news['content'] = $newsContent['content'];
		}

		$webSiteMenu = D('Menu')->getBarMenus();
		$this->assign('webSiteMenu',$webSiteMenu);
		$this->assign('titleFontColor',C('TITLE_FONT_COLOR'));
		$this->assign('copyfrom',C('COPY_FROM'));

		$this->assign('news',$news);
		$this->display();
	}

	// 设置状态
	public function setStatus() {
		$data = array(
			'id' => intval($_POST['id']),
			'status' => intval($_POST['status'])
		);
		return parent::setStatus($data, 'News');
	}

	/*public function setStatus() {
		try {
			if($_POST) {
				$id = $_POST['id'];
				$status = $_POST['status'];
				if(!$id) {
					return show(0, 'ID不存在');
				}
				$res = D('News')->updateStatussById($id, $status);
				if($res) {
					return show(1, '操作成功');
				}else {
					return show(0, '操作失败');
				}
			}
		}catch(Exception $e){
			return show(0, $e->getMessage());
		}
	}*/

	// 更新文章排序
	public function listorder() {
		$listorder = $_POST['listorder'];
		$jumpUrl = $_SERVER['HTTP_REFERER'];
		$errors = array();
		try {
			if($listorder) {
				foreach ($listorder as $newsId => $v) {
					// 执行更新
					$id = D('News')->updateNewsListorderById($newsId, $v);
					if($id === false) {
						$errors[] = $newsId;
					}
				}
				if($errors) {
					return show(0,'排序失败-'.implode(',' ,$errors), array('jump_url' => $jumpUrl));
				}
				return show(1,'排序成功',array('jump_url'=>$jumpUrl));
			}
		}catch(Exception $e) {
			return show(0,$e->getMessage());
		}
		return show(0, '排序数据失败',array('jump_url' => $jumpUrl));
	}

	// 推送文章
	public function push() {
		$jumpUrl = $_SERVER['HTTP_REFERER'];
		$positionId = intval($_POST['position_id']);
		$newsId = $_POST['push'];

		if(!$newsId || !is_array($newsId)) {
			return show(0, '请选择推荐的文章ID进行推荐');
		}
		if(!$positionId) {
			return show(0, '没有选择推荐位');
		}

		try{
			// 校验数据库是否具有相应的文章
			$news = D('News')->getNewsByNewsIdIn($newsId);
			if(!$news){
				return show(0,'没有相关推送文章ID');
			}
			// 执行推送
			foreach ($news as $new) {
				$data = array(
					'position_id' => $positionId,
					'title' => $new['title'],
					'thumb' => $new['thumb'],
					'news_id' => $new['news_id'],
					'status' => $new['status'],
					'create_time' => $new['create_time'],
				);
				$position = D('PositionContent')->insert($data);
			}
		}catch(Exception $e) {
			return show(0, $e->getMessage());
		}
		return show(1, '推荐成功', array('jump_url'=>$jumpUrl));

	}

}