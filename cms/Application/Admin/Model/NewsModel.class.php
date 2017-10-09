<?php
namespace Admin\Model;
use Think\Model;
/**
 * 文章内容content model操作
 * @author abin
 */
class NewsModel extends Model {
	private $_db = '';

	public function __construct() {
		$this->_db = M('news');
	}

	public function getNews($data,$page,$pageSize=10){
		$conditions = $data;
		if(isset($data['title']) && $data['title']) {
			$conditions['title'] = array('like', '%'.$data['title'].'%');
		}
		if(isset($data['catid']) && $data['catid']) {
			$conditions['catid'] = intval($data['catid']);
		}
		// -1表示已删除的文件，不能显示
		$conditions['status'] = array('neq',-1);
		// 起始页数
		$offset = ($page - 1) * $pageSize;
		$list = $this->_db->where($conditions)
			->order('listorder desc ,news_id desc')
			->limit($offset,$pageSize)
			->select();

		return $list;
	}
	// 获取文章总数
	public function getNewsCount($data=array()) {
		$conditions = $data;
		if(isset($data['title']) && $data['title']) {
			$conditions['title'] = array('like','%'.$data['title'].'%');
		}
		if(isset($data['catid']) && $data['catid']) {
			$conditions['catid'] = intval($data['catid']);
		}
		$conditions['status'] = array('neq',-1);

		return $this->_db->where($conditions)->count();
	}

	public function insert($data = array()) {
		if(!is_array($data) || !$data) {
			return 0;
		}

		$data['create_time'] = time();
		$data['username'] = getLoginUsername();
		return $this->_db->add($data);
	}

	// 获取需要编辑的文章信息
	public function find($id) {
		$data = $this->_db->where('news_id='.$id)->find();
		return $data;
	}

	// 文章信息更新
	public function updateById($id, $data) {
		if(!$id || !is_numeric($id)) {
			throw_exception('ID不合法');
		}
		if(!$data || !is_array($data)) {
			throw_exception('更新数据不合法');
		}
		$data['update_time'] = time();
		return $this->_db->where('news_id='.$id)->save($data);
	}
	
	// 修改文章的status
	public function updateStatusById($id, $status) {
		if(!$id || !is_numeric($id)) {
			throw_exception('ID不合法');
		}
		if(!is_numeric($status)) {
			throw_exception('状态不合法');
		}
		$data['status'] = $status;
		$data['update_time'] = time();
		return $this->_db->where('news_id='.$id)->save($data);
	}

	// 更新排序
	public function updateNewsListorderById($id, $listorder) {
		if(!is_numeric($id) || !$id) {
			throw_exception('ID不合法');
		}
		$data = array('listorder'=>intval($listorder));
		return $this->_db->where('news_id='.$id)->save($data);
	}

	// 校验数据库是否具有相应的文章
	public function getNewsByNewsIdIn($newsIds) {
		if(!is_array($newsIds)) {
			throw_exception('参数不合法');
		}
		$data = array(
			'news_id' => array('in',implode(',', $newsIds))
		);
		return $this->_db->where($data)->select();
	}

	/**
     * 获取排行的数据
     * @param array $data
     * @param int $limit
     * @return array
     */
	public function getRank($data = array(), $limit = 100) {
		$list = $this->_db->where($data)->order('count desc,news_id desc')->limit($limit)->select();
		return $list;
	}

	// 更新点击数
	public function updateCount($id, $count) {
		if(!$id || !is_numeric($id)) {
			throw_exception("ID不合法");
		}
		if(!is_numeric($count)) {
			throw_exception('count不能为非数字');
		}

		$data['count'] = $count;
		return $this->_db->where('news_id='.$id)->save($data);
	}

	// 获取文章最大点击数量
	public function maxcount() {
		$data = array(
				'status' => 1,
			);
		return $this->_db->where($data)->order('count desc')->limit(1)->find();
	}
}