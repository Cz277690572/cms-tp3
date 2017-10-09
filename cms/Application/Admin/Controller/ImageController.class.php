<?php
/**
 * 图片相关
 */
namespace Admin\Controller;
use Think\Controller;
use Think\Upload;

/**
 * 文章图片上传管理
 */
class ImageController extends CommonController {
	private $_uploadObj;
	public function __construct() {

	}
	// 缩略图上传
	public function ajaxuploadImage() {
		$upload = D('UploadImage');
		$res = $upload->imageUpload();
		if($res === false) {
			return show(0,'上传失败','');
		}else{
			return show(1,'上传成功',$res);
		}
	}

	// 编辑器图片上传
	public function kindupload() {
		$upload = D('UploadImage');
		$res = $upload->upload();
		if($res === false) {
			return showKind(0,'上传失败！');
		}
		return showKind(1,$res);
	}

}