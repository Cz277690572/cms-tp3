<?php
namespace Admin\Model;
use Think\Model;

/**
 * 用户组操作
 * @author abin
 */
class AdminModel extends Model {
	private $_db = '';

	public function __construct(){
		$this->_db = M('admin');
	}

	/**
	 * 校验用户是否存在
	 */
	public function getAdminByUsername($username='') {
        $res = $this->_db->where('username="'.$username.'"')->find();
        return $res;
    }

    /**
	 * 通过admin_id获取用户信息
	 */
    public function getAdminByUserId($id='') {
        $res = $this->_db->where('admin_id="'.$id.'"')->find();
        return $res;
    }

	/**
	 * 更新用户的登陆时间
	 */
	public function updateByAdminId($id, $data) {
		if(!$id || !is_numeric($id)) {
			throw_exception("ID不合法");
		}
		if(!$data || !is_array($data)) {
			throw_exception('更新的数据不合法');
		}
		return $this->_db->where('admin_id='.$id)->save($data); // 根据条件更新记录
	}

	/**
	 * 获取用户
	 */
	public function getAdmin() {
		$data = array(
				'status' => array(
					'neq', -1
					),
			);
		$res = $this->_db->where($data)->select();
		return $res;
	}

	/**
	 * 添加用户
	 */
	public function insert($data = array()) {
		if(!$data || !is_array($data)) {
			return 0;
		}
		return $this->_db->add($data);
	}

	/**
     * 通过id更新的状态
     * @param $id
     * @param $status
     * @return bool
     */
	public function updateStatusById($id, $status) {
		if(!$id || !is_numeric($id)) {
			throw_exception('id不合法');
		}

		if(!is_numeric($status)) {
            throw_exception("status不能为非数字");
        }
		$data['status'] = $status;
		return $this->_db->where('admin_id='.$id)->save($data);
	}

	// 当天用户登陆数量
	public function getLastLoginUsers() {
		// 当天的开始时间
		$time = mktime(0,0,0,date("m"),date("d"),date("Y"));
		$data = array(
				'status' => 1,
				'lastlogintime' => array('gt',$time)
			);

		return $this->_db->where($data)->count();
	}
}