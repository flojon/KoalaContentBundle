Mercury.on('ready', function() {
    Mercury.config.uploading.url = $('meta[name=mercury-images]').attr('content');
    Mercury.saveUrl = $('meta[name=mercury-content]').attr('content');
	// Enable Mercury after clicking in a mercury region
    $('#mercury_iframe').contents().one('click', ".mercury-region-preview", function() {
        Mercury.trigger('toggle:interface');
    });
});
