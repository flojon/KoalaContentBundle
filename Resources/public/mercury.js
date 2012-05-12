if (top.Mercury) {
  window.Mercury = top.Mercury;
  Mercury.on('ready', function() {
	  Mercury.config.uploading.url = top.$('meta[name=mercury-images]').attr('content');
  });
}

// Enable Mercury after clicking in a mercury region
top.$(document).one('click', ".mercury-region-preview", function(event) {
  Mercury.trigger('toggle:interface');
});
