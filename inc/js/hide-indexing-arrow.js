jQuery(document).ready(function($) {
	let this_filename = 'hide-indexing-arrow.js';
	$("#close-arrow-x").click(function(){
		$("#bouncing-arrow").hide();
		let bouncing_arrow = 'hide this damn thing';
		alert( bouncing_arrow );
		$.ajax({
			type: "POST",
			url: hide_indexing_arrow.hide_arrow_ajaxurl,
			data: {
				'action'                    : 'hide_arrow_request',
				'hide_arrow_filename'       : this_filename,
				'hide_arrow_ajaxurl'        : hide_indexing_arrow.hide_arrow_ajaxurl,
				'hide_arrow_nonce'          : hide_indexing_arrow.hide_arrow_nonce,
				'hide_arrow'                : 'hide',
			},
			success:function(data) {
				$( '#return-hide-arrow' ).html(data);
				console.log(data);
			},
			error: function(jqXHR, textStatus, errorThrown){
				$( '#return-hide-arrow' ).html(errorThrown);
				console.log(errorThrown);
			}
		});
	});
});      
