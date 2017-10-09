<?php
namespace Home\Controller;
use Think\Controller;
use Think\Exception;

class IndexController extends CommonController {
    public function index( $type = '') {
    	// 获取排行
        $rankNews = $this->getRank();
        // 获取广告
        $advNews = D('Admin/PositionContent')->getPositionContent(
        	array(
        		'status'=>1,
        		'position_id'=>5
        		),1,5);
        // 获取首页大图数据
        $topPicNews = D('Admin/PositionContent')->getPositionContent(
        	array(
        		'status'=>1,
        		'position_id'=>3
        		),1,1);

        // 首页3小图推荐
        $topSmailNews = D('Admin/PositionContent')->getPositionContent(
        	array(
        		'status'=>1,
        		'position_id'=>4
        		),1,3);

        // 列表新闻
        $listNews = D('Admin/News')->getNews(array('status'=>1,'thumb'=>array('neq','')),1,30);

        $this->assign('result', array(
        		'topPicNews' => $topPicNews,
        		'topSmailNews' => $topSmailNews,
        		'listNews' => $listNews,
        		'rankNews' => $rankNews,
        		'advNews' => $advNews,
        		'catId' => 0,
        	));
        /*echo '<pre>';
        	print_r($advNews);
        echo '</pre>';exit();*/
        if($type == 'build_html') {
            // index静态文件名，路径，模板文件
            $this->buildHtml('index',HTML_PATH,'Index/index');
        }else{
            $this->display();
        }
        
    }

    public function build_html() {
        $this->index('build_html');
        return show(1, '首页缓存生成成功');
    }

    public function getCount() {
        if(!$_POST) {
            return show(0, '没有任何内容');
        }
        // 文章id是唯一的
        $newsIds = array_unique($_POST);

        try{
            $list = D('Admin/News')->getNewsByNewsIdIn($newsIds);
        }catch (Exception $e) {
            return show(0, $e->getMessage());
        }

        if(!$list) {
            return show(0, 'notdata');
        }
        $data = array();
        foreach ($list as $key => $value) {
            $data[$value['news_id']] = $value['count'];
        }
        return show(1, 'success', $data);
    }


}