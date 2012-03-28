$(document).ready(function(){
	$("#adsize").change(function () {
	  $("#adsize option:selected").each(function () {
	        if(($(this).text()) == "Sonderformat:"){
	        	$(".adsize_misc").show("slide");
	        }
	        else {
	        	$(".adsize_misc").hide("slide");
	        }
	      });
	});	
	$("#referer").change(function () {
	  $("#referer option:selected").each(function () {
	        if(($(this).text()) == "Sonstiges:"){
	        	$(".referer_misc").show("slide");
	        }
	        else {
	        	$(".referer_misc").hide("slide");
	        }
	      });
	});	
	
	jQuery.validator.addMethod("plzort", function(value, element) {
		return this.optional(element) || /^\d{5} [a-z]+$/i.test(value);
	}, "Falsches Format. Beispiel: <em>71111 Waldenbuch</em>");
	
	$(".ad-orderform").validate({
		rules: {
			issue: {
				required: true
			},
			adsize: {
				required: true
			},
			file: {
				accept: "pdf|jpg|jpeg|tiff|PDF|JPG|JPEG|TIFF"
			},
			firm: {
				required: true
			},
			lastname: {
				required: true
			},
			firstname: {
				required: true
			},
			street: {
				required: true
			},
			number: {
				required: true
			},
			city: {
				required: true,
				plzort: true
			},
			phone: {
				required: true,
				digits: true
			},
			fax: {
     			digits: true
			},
			email: {
				required: true,
				email: true
			},
			misc: {
				maxlength: 500
			},
			agb: {
				required: true
			}
		}
	});
	
});