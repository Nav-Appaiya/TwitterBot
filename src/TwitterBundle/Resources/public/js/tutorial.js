/* ========================================================================
 * Tutorial specific Javascript
 * 
 * ========================================================================
 * Copyright 2016 Bootbites.com (unless otherwise stated)
 * For license information see: http://bootbites.com/license
 * ======================================================================== */

var $cardToggles = $('[data-toggle="card-toggle"]');

// Custom functions
// =====================================

// Trigger card toggles
var cardTogglesTrigger = function(init) {  
  $cardToggles.each(function(i) {
    var $cardToggle    = $(this);
    var $cardToggleOff = $cardToggle.find('.card-off');
    var $cardToggleOn  = $cardToggle.find('.card-on');
    var toggler        = $cardToggle.data('toggler') || null; // jQuery selector or if none assume self
    var action         = $cardToggle.data('action') || 'click'; // click or hover (hover only works for $cardToggle)
    var effect         = $cardToggle.data('effect') || null; // Toggle effect: fade, slide up/down


    
    // Init/First run
    // ---------------------------
    if (init === true) {
      if (effect !== null) {
        // If effect set wrapper to same height as on state if on state is taller
        // Use a clone to track actual size as effects use position absolute
        var cardToggleSetHeight = function() {
          var cardToggleOnHeight = $cardToggleOn.outerHeight();
          var $cardToggleClone = $cardToggleOff.clone();
          if (cardToggleOnHeight > 0 && cardToggleOnHeight > $cardToggleOff.outerHeight()) {
            $cardToggleClone = $cardToggleOn.clone();
          }
          $cardToggleClone.addClass('card-on-clone').appendTo($cardToggle);
          
          // Add effect class
          $cardToggle.addClass('card-effect-'+ effect);
        }
  
        // Use imagesLoaded if avaiable: https://github.com/desandro/imagesloaded
        if (jQuery().imagesLoaded) {
          $cardToggle.imagesLoaded(function() {
            cardToggleSetHeight();
          });
        }
        else {
          cardToggleSetHeight();
        }
      }      
      
      // What element triggers toggle
      var $toggler = $cardToggle;
      if (toggler !== null && $cardToggle.find(toggler).length > 0) {
        $toggler = $cardToggle.find(toggler);
        action  = 'click';
      }
      $toggler.addClass('card-toggler');
      
      // Trigger toggle on action (click or hover)
      if (action === 'click') {
        $toggler.on(action, function() {
          if ($cardToggle.hasClass('card-active')) {
            $cardToggle.removeClass('card-active');
          }
          else {
            $cardToggle.addClass('card-active');
          }
          return false;
        });
      }
      else if (action === 'hover') {
        $toggler.mouseover(function() {
          $cardToggle.addClass('card-active');
        }).mouseout(function() {
          $cardToggle.removeClass('card-active');
        });
      }
    }    
  });
}

// On page load
// =========================
$(document).ready(function() {
  if ($cardToggles.length > 0) {
    // Initial card toggles
    cardTogglesTrigger(true);
    
    $(window).on('resize', function() {
      cardTogglesTrigger();
    });
  }
});