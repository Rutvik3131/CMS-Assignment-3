function rp_like_btn_ajax(postId,usrid) {
    
	var post_id = postId;
	var usr_ID = rp_ajax_url.user_id;
	console.log(usr_ID);
		jQuery.ajax({
			url : rp_ajax_url.ajax_url,
			type : 'post',
			data : {
				action : 'rp_like_btn_ajax_action',
				pid : post_id,
				uid : usr_ID
			},
			success : function( response ) {
				jQuery("#rpAjaxResponse").fadeIn();
				jQuery("#rpAjaxResponse span").html(response);
				jQuery("#rpAjaxResponse").delay(5000).fadeOut();
			}
		});
	
}

function rp_dislike_btn_ajax(postId,usrid) {
    
	var post_id = postId;
	var usr_ID = rp_ajax_url.user_id;
	jQuery.ajax({
		url : rp_ajax_url.ajax_url,
		type : 'post',
		data : {
			action : 'rp_dislike_btn_ajax_action',
			pid : post_id,
			uid : usr_ID
		},
		success : function( response ) {
			jQuery("#rpAjaxResponse").fadeIn();
			jQuery("#rpAjaxResponse span").html(response);
			jQuery("#rpAjaxResponse").delay(5000).fadeOut();
		}
	});
	
}