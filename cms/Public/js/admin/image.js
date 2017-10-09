/**
 * 图片上传功能
 */
$(function() {
    $('#file_upload').uploadify({
    	// flash交互
        'swf'      : SCOPE.ajax_upload_swf,
        // post过去的php脚本
        'uploader' : SCOPE.ajax_upload_image_url,
        // 表单上传图片的文案
        'buttonText': '上传图片',
        'fileTypeDesc': 'Image Files',
        'fileObjName' : 'file',
        //允许上传的文件后缀
        'fileTypeExts': '*.gif; *.jpg; *.png',
        'onUploadSuccess' : function(file,data,response) {
            // response true ,false
            if(response) {
                var obj = JSON.parse(data); //由JSON字符串转换为JSON对象

                //console.log(data);
                $('#' + file.id).find('.data').html(' 上传完毕');

                $("#upload_org_code_img").attr("src",obj.data);
                $("#file_upload_image").attr('value',obj.data);
                $("#upload_org_code_img").show();
            }else{
                alert('上传失败');
            }
        },
    });
});

