$(document).ready(function() {

/* 
* 1. init freetile.js 
*/

$('#freetile').children().each(function() {
	$(this).freetile({
		animate: true,
		elementDelay: 5,
		selector: '.item'
	});
});


/* 
* 2. Open / close long posts 
*/

$(".open-button").show();

// prepare some markup
$(document.body).append("<div id='reader' class='reader hidden'><div class='reader-inside'></div><div class='reader-bg close-button'></div></div><div id='mask' class='mask-layer hidden'></div>");
 				
}); // end document ready


/*  
 3. Let's define our closing function
*/

(function( $ ){
  $.fn.closeReader = function() {
  		  $("#reader").fadeOut(300);
  		  $("#mask").fadeOut(300);
  		  return false;
  };
})( jQuery );


(function( $ ){
  $.fn.loadNextItem = function() {
  			// clone the next/previous item
  			var clonage = $("#planet-item-"+window.item_nr+" .item-inside").clone(true);
  		  $('#reader .reader-inside').html(clonage);
  		  $('#reader .post-content').css({'height': 'auto','max-height': window.new_container_height+'px'});
  };
})( jQuery );


/*  
 4. What happens when we open the reader
*/

$(".open-button").on("click", function() {

				var clonage = $(this).parent().clone(true);
				
				window.item_nr = $(this).parent().parent('.item').attr('id').slice(12);
				
				var item_height = $(this).parent().height();
				window.new_container_height = ($(window).height()) - 260;
						    
				$('#reader').fadeIn(300);
				$('#mask').fadeIn(300);
				
				$('#reader .reader-inside').html(clonage);
				
				$('#reader .post-content').css({'height': 'auto','max-height': new_container_height+'px'});
				
				// alert("item is: " + window.item_nr);
				return false;
});


/*  
 5. What happens when we close the reader
*/

$(".close-button").on("click", function() {
	$(document).closeReader();
});

// Use the ESC key:
$(document).keyup(function(e) {
  if (e.keyCode == 27) { 
  	$(document).closeReader();
  }
});

/*  
 6. What happens when we click on the LEFT or RIGHT arrow keys
*/

$(document).keydown(function(e){
    if (e.keyCode == 37) { 
    		// LOAD content of prev item.
    		if (window.item_nr == 1) {
    			$(document).closeReader();
    		} else if (window.item_nr) {
	       	window.item_nr = parseInt(window.item_nr) - 1;
	       	$(document).loadNextItem();
	      }
    }
});

/*  
 7. What happens when we click on the LEFT or RIGHT arrow keys
*/

$(document).keydown(function(e){
    if (e.keyCode == 39) { 
				// LOAD content of next item.
				if (window.item_nr) {
				    window.item_nr = parseInt(window.item_nr) + 1;
				    $(document).loadNextItem();
				} 
    }
});

/* 
 * that's it - thanks for reading !
 ****************************************************
 */

