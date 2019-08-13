jQuery(document).ready(function($) {
	let this_filename = 'page-template-request.js';
	$("#page_id").change(function(e) {
		e.preventDefault();
		$.ajax({
			type: "POST",
			url: template_request_object.template_request_ajaxurl,
			data: {
				'action'                    : 'page_template_request',
				'ajax_filename'             : this_filename,
				'template_request_ajaxurl'  : template_request_object.template_request_ajaxurl,
				'template_request_nonce'    : template_request_object.template_request_nonce,
				'returned_id'               : $('#page_id').val(),
			},
			success:function(data) {
				obj = JSON.parse(data);
				$( '#return-page-template' ).html( 'The template used on this page is ' + obj.page_template );
				console.log(data);
			},
			error: function(jqXHR, textStatus, errorThrown){
				$( '#return-page-template' ).html(errorThrown);
				console.log(errorThrown);
			}
		});  
	});      
});