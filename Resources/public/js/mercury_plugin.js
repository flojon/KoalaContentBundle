Mercury.on('ready', function() {
    Mercury.config.uploading.url = $('meta[name=mercury-images]').attr('content');
    Mercury.saveUrl = $('meta[name=mercury-content]').attr('content');
    // Enable Mercury after clicking in a mercury region
    $('#mercury_iframe').contents().one('click', ".mercury-region-preview", function() {
        Mercury.trigger('toggle:interface');
    });
});

Mercury.config.toolbars.primary.sep10 = '-';
Mercury.config.toolbars.primary.page = {
    newPage: ['New Page', 'Create a new page', {modal: $('meta[name=mercury-new]').attr('content')}],
    editPage: ['Edit Page', 'Edit page settings', {modal: $('meta[name=mercury-edit]').attr('content')}],
}

// Define confirmation and action through data-confirm and data-action attributes
$(document).on('click', "input[data-confirm]", function() {
    if (confirm($(this).attr('data-confirm'))) {
        $('<form>') // create new form
            .attr('method', 'post') // post method
            .attr('action', $(this).attr('data-action')) // set action url
            .submit(); // submit
    }
});
