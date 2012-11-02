/* init freetile.js 
 ********************
*/

;(function($){
	$(document).ready(function() {
		$('#freetile').children().each(function() {
			$(this).freetile({
				animate: true,
				elementDelay: 5,
				selector: '.item'
			});
		});
	});
})(jQuery);

				
$(document).ready(function() {	

/* 
* Open / close long posts 
*/

$(".open-button").show();

// prepare some markup

$(document.body).append("<div id='reader' class='reader hidden'><div class='reader-inside'></div></div><div id='mask' class='mask-layer hidden close-button'></div>");


/*  
 1. Let's define our closing function
*/

(function( $ ){
  $.fn.closeReader = function() {
  		  $("#reader").fadeOut(200);
  		  $("#mask").fadeOut(200);
  		  return false;
  };
})( jQuery );


/*  
 2. What happens when we click the button
*/

$(".open-button").on("click", function() {

	var clonage = $(this).parent().clone(true);
	
	var item_height = $(this).parent().height();
	var new_container_height = ($(window).height()) - 260;
	
	// $(this).removeClass('closed').addClass('open');
		    
	$('#reader').fadeIn(200);
	$('#reader .reader-inside').html(clonage);
	
	// alert ('height:'+new_container_height);
	// $('#reader .post-content').css({'height': new_container_height+'px'});
	$('#reader .post-content').css({'height': 'auto','max-height': new_container_height+'px'});
		    
	$('#mask').fadeIn(200);
	return false;
});

/*  
 2. What happens when we close the reader
*/

$("#mask").on("click", function() {
	// alert('close');
	$(document).closeReader();
});

$(".close-button").on("click", function() {
	// alert('close');
	$(document).closeReader();
});

// Use the ESC key:

$(document).keyup(function(e) {
  if (e.keyCode == 27) { 
  	//alert('ok');
  	//$(this).closeReader(); 
  	
  	$(document).closeReader();
  	
  	// well... we don't know what THIS is...
  }   // esc
});

/* 
 * that's it - thanks for reading !
 ****************************************************
 */
 				
}); // end document ready