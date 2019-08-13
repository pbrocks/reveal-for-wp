jQuery(document).ready(function($) {
	let this_filename = 'wp-admin-grid.js';
	$("#wp-admin-grid-page").click(function(e) {
		alert('wp-admin-grid.js');
		e.preventDefault();

		$.ajax({
			type: "POST",
			url: code_sample_object.code_ajaxurl,
			data: {
				'action': 'code_sample_request',
				'ajax_filename'   : this_filename,
				'code_ajaxurl' : code_sample_object.code_ajaxurl,
				'trigger_nonce'   : code_sample_object.trigger_nonce,
				'input1_ajax'     : $('#input1-ajax').val(),
				'hidden_input'    : $('#hidden-input').val(),
				'explanation_one' : code_sample_object.explanation_one,
				'explanation_two' : 'Grab info from javascript and include here (' + this_filename + ').',
			},
			success:function(data) {
				$( '#return-wp-admin-grid' ).html(data);
				console.log(data);
			},
			error: function(jqXHR, textStatus, errorThrown){
				$( '#return-wp-admin-grid' ).html(errorThrown);
				console.log(errorThrown);
			}
		});  
	});      
});