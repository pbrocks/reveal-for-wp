jQuery(document).ready(function($){
    $("#show-reveal").hide();
    $("#is-this-for-reveal").click(function () {
        if ($(this).is(":checked")) {
            $("#show-reveal").show('slow');
        } else {
            $("#show-reveal").hide('slow');
        }
    });
});
// Reveal.addEventListener( 'ready', function( event ) {
	// event.currentSlide, event.indexh, event.indexv
// } );