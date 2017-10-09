<?php
namespace Admin\Model;
use Think\Model;

/**
 * 图片上传类
 * @author abin
 */
class UploadImageModel extends Model {
	private $_uploadObj = '';
	private $_uploadImageData = '';

	const UPLOAD = 'upload';

	public function __construct() {
		$this->_uploadObj = new  \Think\Upload();

        $this->_uploadObj->rootPath = './'.self::UPLOAD.'/';
        $this->_uploadObj->subName = date(Y) . '/' . date(m) .'/' . date(d);
	}

	// 缩略图上传
	public function imageUpload() {
		$res = $this->_uploadObj->upload();
        
        if($res) {
            return '/' .self::UPLOAD . '/' . $res['file']['savepath'] . $res['file']['savename'];
        }else{
            return false;
        }
	}

	// 编辑器图片上传
	public function upload() {
		$res = $this->_uploadObj->upload();

		if($res) {
			return '/' .self::UPLOAD. '/' . $res['imgFile']['savepath'] . $res['imgFile']['savename'];
		}else{
			return false;
		}
	}


}