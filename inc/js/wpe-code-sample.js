jQuery(document).ready(function($) {
	let this_filename = 'wpe-code-sample.js';
	$("#wpe-code-sample-page").click(function(e) {
		alert('wpe-code-sample.js');
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
				$( '#return-wpe-code-sample' ).html(data);
				console.log(data);
			},
			error: function(jqXHR, textStatus, errorThrown){
				$( '#return-wpe-code-sample' ).html(errorThrown);
				console.log(errorThrown);
			}
		});  
	});      
});