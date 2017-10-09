<?php
namespace Admin\Model;
use Think\Model;

class PositionModel extends Model {
	private $_db = '';

	public function __construct() {
		$this->_db = M('position');
	}

	// 获取正常推荐位
	public function getNormalPositions() {
		$conditions = array(
				'status' => array('neq',-1),
			);
		$list = $this->_db->where($conditions)->order('id')->select();
		return $list;
	}

	// 添加推荐位
	public function insert($data = array()) {
		if(!$data || !is_array($data)) {
			return 0;
		}
		$data['create_time'] = time();

		return $this->_db->add($data);
	}

	// 获取及时编辑内容
	public function find($id) {
		$data = array(
			'status' => array('neq',-1),
			'id' => array('eq',$id)
		);
		return $this->_db->where($data)->find();
	}

	// 更新
	public function updateById($id, $data) {
		if(!$id || !is_numeric($id)) {
			throw_exception('ID不合法');
		}
		if(!$data || !is_array($data)) {
			throw_exception('更新数据不合法');
		}
		$data['update_time'] = time();
		return $this->_db->where('id='.$id)->save($data);
	}

	/**
	 * 通过id更新的状态
	 * @param $id
	 * @param $status
	 * @return bool
	 */
	public function updateStatusById($id, $status) {
		if(!is_numeric($status)) {
			throw_exception("status不能为非数字");
		}
		if(!$id || !is_numeric($id)) {
			throw_exception("ID不合法");
		}
		$data['status'] = $status;
		$data['update_time'] = time();
		return  $this->_db->where('id='.$id)->save($data); // 根据条件更新记录

	}

	// 获取推荐位数量
	public function getCount($data=array()) {
		$conditions = $data;
		return $this->_db->where($conditions)->count();
	}
}