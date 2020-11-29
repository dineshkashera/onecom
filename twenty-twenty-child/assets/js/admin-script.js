/**
 * Frontend js for header
 */
var siteurl = CALL.siteurl;//siteurl
var ajaxurl = CALL.ajaxurl;//ajaxurl

jQuery(document).ready(function(){

	//mark featured and hot
	jQuery('.featured_post,.hot_post').click(function(){

		var mark_action 	= 	jQuery(this).attr('class');
		var postid 			=	jQuery(this).attr('data-postid');

		if(jQuery(this).is(':checked')){
			checked_status = 'checked';
		}else{
			checked_status = 'unchecked';
		}
		
	    jQuery.ajax({
	         type : "post",
	         dataType : "json",
	         url : ajaxurl,
	         data : {
	         		action: "mark_post_featured_hot", post_id : postid, mark_status : mark_action, checked_status : checked_status  
	         },
	         success: function(response) {
	            if(response.type == "success") {
	              console.log(response.type);
	            }
	        }
	     });
	});
});