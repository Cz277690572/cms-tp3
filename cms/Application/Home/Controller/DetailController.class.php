<?php
namespace Home\Controller;
use Think\Controller;
class DetailController extends CommonController {
	public function index() {
		$id = intval($_GET['id']);
		if(!$id || $id < 0) {
			return $this->error('ID不合法');
		}

		$news = D('Admin/News')->find($id);

		if(!$news || $news['status'] != 1) {
			return $this->error("ID不存在或者咨询被关闭");
		}

		$count = intval($news['count']) + 1;
		D('Admin/News')->updateCount($id, $count);

		$content = D('Admin/NewsContent')->find($id);
		$news['content'] = htmlspecialchars_decode($content['content']);
		$advNews = D("Admin/PositionContent")->select(array('status'=>1,'position_id'=>5),2);
        $rankNews = $this->getRank();

        $this->assign('result',array(
        		'rankNews' => $rankNews,
        		'advNews' => $advNews,
        		'catId' => $news['catId'],
        		'news' => $news,
        	));
        $this->display('Detail/index');
	}

	public function view() {
		if(!getLoginUsername()) {
			$this->error('你没有权限访问该页面');
		}
		$this->index();
	}
}