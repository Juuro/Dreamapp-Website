$(document).ready(    
    
	function(){
   		$(".jtagfeld,.tagfeld,.heute").hover(
    		
			function(){
    			var timestamp = $(this).attr('class').split(' ').slice(-1);    			
    			
    			$.ajax({
    				type: "GET",
    				url: "getDateDetails.php",
    				data: "timestamp=" + timestamp,
    				success: function(msg){
    					if(msg != ""){
							$("."+timestamp).append("<div class='sidebox occupied'><div class='boxhead'><h2>belegt</h2></div><div class='boxbody'>"+msg+"</div></div>");
    					}
    					/*
    					else {
    						$("."+timestamp).append("<div class='sidebox available'><div class='boxhead'><h2>frei</h2></div><div class='boxbody'>Dieser Tag ist nicht belegt!</div></div>");
    					}
    					*/
  		    			$(".sidebox").fadeIn(300);
    				}
    			});    			
    		},
			function () {
				$(".sidebox").remove();
			}
    	);
			
    	$("#start_date, #end_date, #end_date").focus(function() {
    		    		
    		var p = $("#start_date");
    		var offset = p.offset();    		
    		var left = offset.left+206;
    		left.toString();  		
			$("#ui-datepicker-div").css("left", left+"px");	
			
			$.get("css/cupertino/jquery-ui.custom.css", function(css) {
				$("head").append("<style>"+css+"</style>");
			});
		});		
		
		$("#start_date, #end_date, #end_date").datepicker();
		
		/* German initialisation for the jQuery UI date picker plugin. */
		/* Written by Milian Wolff (mail@milianw.de). */
		jQuery(function($){
			$.datepicker.regional['de'] = {
				closeText: 'schließen',
				prevText: '&#x3c;zurück',
				nextText: 'Vor&#x3e;',
				currentText: 'heute',
				monthNames: ['Januar','Februar','März','April','Mai','Juni',
				'Juli','August','September','Oktober','November','Dezember'],
				monthNamesShort: ['Jan','Feb','Mär','Apr','Mai','Jun',
				'Jul','Aug','Sep','Okt','Nov','Dez'],
				dayNames: ['Sonntag','Montag','Dienstag','Mittwoch','Donnerstag','Freitag','Samstag'],
				dayNamesShort: ['So','Mo','Di','Mi','Do','Fr','Sa'],
				dayNamesMin: ['So','Mo','Di','Mi','Do','Fr','Sa'],
				weekHeader: 'Wo',
				dateFormat: 'dd.mm.yy',
				firstDay: 1,
				isRTL: false,
				showMonthAfterYear: false,
				yearSuffix: ''};
			$.datepicker.setDefaults($.datepicker.regional['de']);
		});
    	    	
    }   
);


