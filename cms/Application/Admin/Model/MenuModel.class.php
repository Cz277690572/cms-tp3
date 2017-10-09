<?php
namespace Admin\Model;
use Think\Model;

class MenuModel extends Model {
	private $_db = '';
	public function __construct() {
		$this->_db = M('menu');
	}

	public function insert($data = array()) {
		if(!$data || !is_array($data)) {
			return 0;
		}
		return $this->_db->add($data);
	}

	public function getMenus($data,$page,$pageSize=10) {
		$data['status'] = array('neq',-1);
		// 起始页数
		$offset = ($page - 1) * $pageSize;
		$list = $this->_db->where($data)->order('listorder desc, menu_id desc')->limit($offset,$pageSize)->select();
		return $list;
	}
	/**
	 * 查询menu总数
	 */
	public function getMenusCount($data = array()) {
		$data['status'] = array('neq',-1);
		return $this->_db->where($data)->count();
	}

	/**
	 * 获取编辑菜单信息
	 */
	public function find($id) {
		if(!$id || !is_numeric($id)) {
			return array();
		}
		return $this->_db->where('menu_id='.$id)->find();
	}

	/**
	 * 更新菜单信息
	 */
	public function updateMenuById($id, $data) {
		if(!$id || !is_numeric($id)) {
			throw_exception('ID不合法');
		}
		if(!$data || !is_array($data)) {
			throw_exception('更新的数据不合法');
		}
		return $this->_db->where('menu_id='.$id)->save($data);
	}

	/**
	 * 设置菜单状态-1，并非真正删除
	 */
	public function updateStatusById($id, $status) {
		if(!$id || !is_numeric($id)) {
			throw_exception('ID不合法');
		}
		if(!$status || !is_numeric($status)) {
			throw_exception('状态不合法');
		}
		$data['status'] = $status;
		return $this->_db->where('menu_id='.$id)->save($data);
	}

	/**
	 * 更新列表表单排序
	 */
	public function updateMenuListorderById($menuId, $listorder){
		if(!$menuId || !is_numeric($menuId)) {
			throw_exception('menuID不合法');
		}

		$data = array(
				'listorder' => intval($listorder),
			);
		return $this->_db->where('menu_id='.$menuId)->save($data);
	}

	/**
	 * 获取后台左侧菜单栏目
	 */
	public function getAdminMenus() {
		$data = array(
			'status' => array('neq',-1),
			'type' => 1,
		);
		return $this->_db->where($data)
		->order('listorder desc,menu_id desc')
		->select();
	}

	// 获取新闻所属栏目
	public function getBarMenus() {
        $data = array(
            'status' => 1,
            'type' => 0,
        );

        $res = $this->_db->where($data)
            ->order('listorder desc,menu_id desc')
            ->select();
        return $res;
    }

}