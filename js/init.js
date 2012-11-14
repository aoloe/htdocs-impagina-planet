;(function($){
	$(document).ready(function() {
		$('#freetile').children().each(function()
		{
			$(this).freetile({
				animate: true,
				elementDelay: 5,
				selector: '.item'
			});
		});
	});
})(jQuery)
				
