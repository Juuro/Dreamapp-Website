$(document).ready(function() {
	//When page loads...
	$(".tab_content").hide(); //Hide all content
	$("ul.navi li:first").addClass("active").show(); //Activate first tab
	$(".tab_content:first").show(); //Show first tab content

	//On Click Event
	$("ul.navi li").click(function() {

		$("ul.navi li").removeClass("active"); //Remove any "active" class
		$(this).addClass("active"); //Add "active" class to selected tab
		$(".tab_content").hide(); //Hide all tab content

		var activeTab = $(this).find("a").attr("href"); //Find the href attribute value to identify the active tab + content
		$(activeTab).fadeIn(); //Fade in the active ID content
		return false;
	});
	
	$(".message").slideDown('slow').animate({opacity: 1.0}, 3000).fadeOut('slow');
	$("body").click(function() {
		$(".message").hide();
	});
	
	if ($(document).getUrlParam("data")){
		$("ul.navi li").removeClass("active");
		$("ul.navi li:first").next().addClass("active");
		$(".tab_content").hide(); //Hide all tab content	
		
		$("#tab02").fadeIn(); //Fade in the active ID content
		return false;
	}
	
	
	
	
	$("input[name='check_all']").click(function(){
		if($(this).val()==0){
			$(this).parents("table")
					.find("input:checkbox")
					.attr("checked","checked")
					.val("1");
		}
		else{
			$(this).parents("table")
					.find("input:checkbox")
					.attr("checked","")
					.val("0");
			}
		});
	
});