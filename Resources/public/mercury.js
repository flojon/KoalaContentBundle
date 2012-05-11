// Enable Mercury after clicking in a mercury region
top.$(document).on('click', ".mercury-region-preview", function(event) {
  Mercury.trigger('toggle:interface');
});
