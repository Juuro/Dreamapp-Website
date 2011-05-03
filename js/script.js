$(function(){

	
	
	// apply spans
      $("h2").lettering();
      
      // hack to get animations to run again
      $(".redraw").click(function() {	
        var el = $(this),  
           prev = el.prev(),
           newone = prev.clone();
        el.before(newone);
        $("." + prev.attr("class") + ":first").remove();
      }); 
        
	  var text = $("#jquerybuddy"),
		  numLetters = text.find("span").length;
		
	  function randomBlurize() {
		text.find("span:nth-child(" + (Math.floor(Math.random()*numLetters)+1) + ")")
		    .animate({
		      'textShadowBlur': Math.floor(Math.random()*30)+4,
		      'textShadowColor': 'rgba(255,255,255,' + (Math.floor(Math.random()*200)+55) + ')'
		    });
		// Call itself recurssively
		setTimeout(randomBlurize, 100);
	  } // Call once
	  randomBlurize();

	
});
