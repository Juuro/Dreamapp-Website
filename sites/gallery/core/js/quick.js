$(document).ready(function() {
  if ($("#gAlbumGrid").length) {
	// @todo Add quick edit pane for album (meta, move, permissions, delete)
	//$("#gInfo").hover(show_quick, function() {});
	$(".gItem").hover(show_quick, function() {});
  }
  if ($("#gItem").length) {
	// @todo Apply quick edit to resize view
  }
});

var show_quick = function() {
  var cont = $(this);
  var quick = $(this).find(".gQuick");
  $("#gQuickPane").remove();
  cont.append("<div id=\"gQuickPane\"></div>");
  var img = cont.find(".gThumbnail");
  var pos = cont.position();
  $("#gQuickPane").css({
    "position": "absolute",
    "top": pos.top,
    "left": pos.left,
    "width": cont.innerWidth() + 1,
    "height": 32
  }).hide();
  cont.hover(function() {}, hide_quick);
  $.get(
    quick.attr("href"),
    {},
    function(data, textStatus) {
      $("#gQuickPane").html(data).slideDown("fast");
      $("#gQuickPane a").click(function(e) {
        e.preventDefault();
        quick_do(cont, $(this), img);
      });
    }
  );
};

var quick_do = function(cont, pane, img) {
  if (pane.hasClass("gDialogLink")) {
    openDialog(pane, function() { window.location.reload(); });
  } else {
    img.css("opacity", "0.1");
    cont.addClass("gLoadingLarge");
    $.ajax({
      type: "GET",
      url: pane.attr("href"),
      dataType: "json",
      success: function(data) {
	img.css("opacity", "1");
	cont.removeClass("gLoadingLarge");
	if (data.src) {
	  img.attr("width", data.width);
	  img.attr("height", data.height);
	  img.attr("src", data.src);
	  if (data.height > data.width) {
	    img.css("margin-top", -32);
	  } else {
	    img.css("margin-top", 0);
	  }
        } else if (data.location) {
          window.location = data.location;
	} else if (data.reload) {
          window.location.reload();
	}
      }
    });
  }
  return false;
};

var hide_quick = function() {
  $("#gQuickPane").remove();
};
