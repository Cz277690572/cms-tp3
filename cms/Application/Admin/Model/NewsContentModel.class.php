<?php
namespace Admin\Model;
use Think\Model;

/**
 * @author abin
 */
class NewsContentModel extends Model {
	private $_db = '';

	public function __construct() {
		$this->_db = M('news_content');
	}

	// 编辑器内容插入
	public function insert($data=array()) {
		if(!$data || !is_array($data)) {
			return 0;
		}
		$data['create_time'] = time();
		if(isset($data['content']) && $data['content']) {
			$data['content'] = htmlspecialchars($data['content']);
		}
		return $this->_db->add($data);
	}

	// 获取编辑内容的信息
	public function find($id) {
		$data = $this->_db->where('news_id='.$id)->find();
		return $data;
	}

	// 文章编辑内容更新
	public function updateNewsById($id, $data) {
		if(!is_numeric($id) || !$id) {
			throw_exception('ID不合法');
		}
		if(!is_array($data) || !$data) {
			throw_exception('更新数据不合法');
		}
		$data['update_time'] = time();
		if(isset($data['content']) && $data['content']) {
			$data['content'] = htmlspecialchars($data['content']);
		} 

		return $this->_db->where('news_id='.$id)->save($data);
	}

}