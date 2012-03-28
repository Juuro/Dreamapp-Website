/**
 * Initialize jQuery UI and Plugin elements
 *
 * @todo Standardize how elements requiring listeners are identified (class or id)
 */

var shortForms = new Array(
  "#gSearchForm",
  "#gAddTagForm"
);

$(document).ready(function() {
  
  // Initilize menus  
  $("ul.gMenu").addClass("sf-menu");
  $("#gViewMenu ul.gMenu").addClass("sf-menu");
  
  // Superfish menu options
  $('ul.sf-menu').superfish({
    delay: 500,
    animation: {
      opacity:'show',
      height:'show'
    },
    speed: 'fast'
  });

  // Album view only
  if ($("#gAlbumGrid").length) {
    // Vertical align thumbnails/metadata in album grid
    $('.gItem').vAlign();
  }

  // Photo/Item item view only
  if ($("#gItem").length) {
    // Ensure that sized image versions
    // fit inside their container
    sizedImage();

    // Add scroll effect for links to named anchors
    $.localScroll({
      queue: true,
      duration: 1000,
      hash: true
    });
  }

  // Apply modal dialogs
  $(".gMenuLink").addClass("gDialogLink");
  $("#gLoginLink").addClass("gDialogLink");
  var dialogLinks = $(".gDialogLink");
  for (var i=0; i < dialogLinks.length; i++) {
    $(dialogLinks[i]).bind("click", {element: dialogLinks[i]}, handleDialogEvent);
  }

  // Short forms
  handleShortFormEvent(shortForms);

});

// Vertically align a block element's content
(function ($) {
  $.fn.vAlign = function(container) {
    return this.each(function(i){
      if (container == null) {
        container = 'div';
      }
      $(this).html("<" + container + ">" + $(this).html() + "</" + container + ">");
      var el = $(this).children(container + ":first");
      var elh = $(el).height();
      var ph = $(this).height();
      var nh = (ph - elh) / 2;
      $(el).css('margin-top', nh);
    });
  };
})(jQuery);

/**
 * Reduce width of sized photo if it's wider than its parent container
 */
function sizedImage() {
  var containerWidth = $("#gItem").width();
  var oPhoto = $("#gItem img").filter(function() {
    return this.id.match(/gPhotoId-/);
  });
  if (containerWidth < oPhoto.width()) {
    var proportion = containerWidth / oPhoto.width();
    oPhoto.width(containerWidth);
    oPhoto.height(proportion * oPhoto.height());
  }
}

/**
 * Handle initialization of all short forms
 *
 * @param shortForms array Array of short form IDs
 */
function handleShortFormEvent(shortForms) {
  for (var i in shortForms) {
    shortFormInit(shortForms[i]);
  }
}

/**
 * Initialize a short form. Short forms may contain only one text input.
 *
 * @param formID string The form's ID, including #
 */
function shortFormInit(formID) {
  // Get the input ID and it's label text
  var labelValue = $(formID + " label:first").html();
  var inputID = "#" + $(formID + " input[type='text']:first").attr("id");

  // Set the input value equal to label text
  $(inputID).val(labelValue);

  // Attach event listeners to the input
  $(inputID).bind("focus blur", function(e){
    var eLabelVal = $(this).siblings("label").html();
    var eInputVal = $(this).val();

    // Empty input value if it equals it's label
    if (eLabelVal == eInputVal) {
        $(this).val("");
    // Reset the input value if it's empty
    } else if ($(this).val() == "") {
      $(this).val(eLabelVal);
    }
  });
}
