/**
 * 添加按钮操作
 */
 $("#button-add").click(function(){
 	var url = SCOPE.add_url;
 	window.location.href=url;
 });

 /**
  * 添加form表单操作
  */
$("#singcms-button-submit").click(function(){
 	var data = $('#singcms-form').serializeArray();
 	postData = {};
 	$(data).each(function(i){
 		postData[this.name] = this.value;
 	});
 	console.log(postData);

 	// 将获取到的数据post给服务器
 	url = SCOPE.save_url;
 	jump_url = SCOPE.jump_url;
 	$.post(url,postData,function(result){
 		if(result.status == 1) {
 			// 成功
 			return dialog.success(result.message,jump_url);
 		}else if(result.status == 0){
 			// 失败
 			return dialog.error(result.message);
 		}
 	},"JSON");
});

/**
 * 编辑模式
 */
$('.singcms-table #singcms-edit').on('click',function(){
	var id = $(this).attr('attr-id');
	var url = SCOPE.edit_url + '&id='+id;
	window.location.href=url;
});

/**
 * 删除操作JS
 */
$('.singcms-table #singcms-delete').on('click',function(){
	var id = $(this).attr('attr-id');
	var a = $(this).attr('attr-a');
	var message = $(this).attr('attr-message');
	var url = SCOPE.set_status_url;

	data = {};
	data['id'] = id;
	data['status'] = -1;
	console.log(data);

	layer.open({
		type: 0,
		title: '是否提交？',
		btn: ['yes','no'],
		icon: 3,
		closeBtn: 2,
		content: "是否确认"+message,
		scroller: true,
		yes: function(){
			// 执行相关跳转
			todelete(url,data);
		},
	});

});

function todelete(url, data) {
	$.post(
		url,
		data,
		function(s){
			if(s.status == 1) {
				// 跳转至相关页面
				return dialog.success(s.message,'');
			}else{
				return dialog.error(s.message);
			}
		},'JSON');
}

/**
 * 排序操作
 */
$('#button-listorder').click(function() {
	// 获取 listorder内容
	var data = $("#singcms-listorder").serializeArray();
	postData = {};
	$(data).each(function(i){
		postData[this.name] = this.value;
	});
	console.log(postData);

	var url = SCOPE.listorder_url;
	$.post(url,postData,function(result){
		if(result.status == 1){
			// 成功
			return dialog.success(result.message,result['data']['jump_url']);
		}else{
			// 失败
			return dialog.error(result.message,result['data']['jump_url']);
		}
	},'JSON');
});


/**
 * 修改状态
 */
$('.singcms-table #singcms-on-off').on('click', function(){

    var id = $(this).attr('attr-id');
    var status = $(this).attr("attr-status");
    var url = SCOPE.set_status_url;

    data = {};
    data['id'] = id;
    data['status'] = status;

    layer.open({
        type : 0,
        title : '是否提交？',
        btn: ['是', '否'],
        icon : 3,
        closeBtn : 2,
        content: "是否确定更改状态",
        scrollbar: true,
        yes: function(){
            // 执行相关跳转
            todelete(url, data);
        },

    });

});

/**
 * 推送JS相关
 */
$('#singcms-push').click(function(){
	var id = $('#select-push').val();
	if(id==0) {
		return dialog.error('请选择推荐位');
	}
	push = {};
	postData = {};
	$("input[name='pushcheck']:checked").each(function(i){
		push[i] = $(this).val();
	});

	postData['push'] = push;
	postData['position_id'] = id;
	console.log(postData);
	var url = SCOPE.push_url;
	$.post(url, postData, function(result){
		if(result.status == 1) {
			// 推送ok
			return dialog.success(result.message,result['data']['jump_url']);
		}
		if(result.status == 0) {
			// 推送no
			return dialog.error(result.message);
		}
	},'JSON');
});