<script type='text/javascript'>
$(document).ready(function(){ 
	
	var ismobile = (/iphone|ipod|Mobile|blackberry|opera|mini|windows\sce|palm|smartphone|iemobile/i.test(navigator.userAgent.toLowerCase()));
	//Scrolling for mobile
	if(ismobile)
	{
		var hContent = $("body").height(); // get the height of your content
    	var hWindow =  ($(window).height())+200;  // get the height of the visitor's browser window
		
		$('#scroll_bottom').hide();
		$('#scroll_top').hide(); 
		
		if(hContent>hWindow) { 
        $('#scroll_bottom').show();
		//$('#scroll_top').show();  
		}
		else
		{
			$('#scroll_bottom').hide(); 
			$('#scroll_top').hide(); 
		}
		//Show bottom to top icon when scroll reach at bottom of the page
		
		$(window).scroll(function(){ 
			if ($(this).scrollTop() > 200) { 
			
				$('#scroll_top').show(); 
				$('#scroll_bottom').show();
			} 
			else {
				var scroll_bottom_visible=$('#scroll_top:visible').length;
				if(scroll_bottom_visible==1)
				{
					$('#scroll_bottom').show(); 
				}
				$('#scroll_top').hide();
				 
			}
			
		});
		
		//Show bottom to top icon when scroll reach at bottom of the page
		 $(window).scroll(function() {
			   var scroll_top_visible=$('#scroll_bottom:visible').length;
			   if (($('body').height()-50) <= ($(window).height() + $(window).scrollTop()) && scroll_top_visible==1) {
				   $('#scroll_top').show();
				   $('#scroll_bottom').hide(); 
				   $('#scroll_top').css({"bottom":"8px"}); 
			   }
			   else
			   {	
			   	   $('#scroll_top').css({"bottom":"33px"}); 
			   }
		  });
	}
	//Scrolling for desktop and tablet
	else
	{
	
		var hContent = $("body").height(); // get the height of your content
		var hWindow =  $(window).height(); // get the height of the visitor's browser window
	
		if(hContent>hWindow) { 
			$('#scroll_bottom').show();
			//$('#scroll_top').show();  
		}
		else
		{
			$('#scroll_bottom').hide(); 
			$('#scroll_top').hide(); 
		}
		
		//Show bottom to top icon when scroll reach at bottom of the page
		$(window).scroll(function(){ 
			if ($(this).scrollTop() > 5) { 
				$('#scroll_top').show(); 
				$('#scroll_bottom').show();
			} else { 
				$('#scroll_top').hide();
				$('#scroll_bottom').show(); 
			}
			
		});
		
		//Show bottom to top icon when scroll reach at bottom of the page
		 $(window).scroll(function() {
			   if (($('body').height()-2) <= ($(window).height() + $(window).scrollTop())) {
			   	   $('#scroll_top').show();
				   $('#scroll_bottom').hide();
				   $('#scroll_top').css({"bottom":"20px"}); 
			   }
			   else
			   {	
			   	   $('#scroll_top').css({"bottom":"33px"}); 
			   }
		  });
	}
	//Scroll top to bottom
	$('#scroll_bottom').click(function(){ 
		$("html, body").animate({ scrollTop: $(document).height() }, 0); 
		return false; 
	}); 
	//Scroll bottom to top
	$('#scroll_top').click(function(){ 
		$("html, body").animate({ scrollTop: 0 }, 0); 
		return false; 
	}); 
	
});
</script>	