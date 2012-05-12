// Enable Mercury after clicking in a mercury region
top.$(document).one('click', ".mercury-region-preview", function(event) {
  Mercury.trigger('toggle:interface');
});
