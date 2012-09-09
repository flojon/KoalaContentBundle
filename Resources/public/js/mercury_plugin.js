var page_id = $('meta[name=page-id]').attr('content');

Mercury.on('ready', function() {
    Mercury.config.uploading.url = Routing.generate('koala_content_mercury_images', {page_id: page_id});
    // Enable Mercury after clicking in a mercury region
    $('#mercury_iframe').contents().one('click', "[contenteditable=false]", function() {
        Mercury.trigger('toggle:interface');
    });
});

Mercury.config.toolbars.primary.sep10 = '-';
Mercury.config.toolbars.primary.page = {
    newPage: ['New Page', 'Create a new page', {modal: Routing.generate('koala_content_page_new')}],
    editPage: ['Edit Page', 'Edit page settings', {modal: Routing.generate('koala_content_page_edit', {page_id: page_id})}],
}

Mercury.on('saved', function() {
    $('#flash-messages')
        .html('<div class="success">Page saved successfully!</div>')
        .find('div.success')
            .fadeIn('fast')
            .delay(3000)
            .fadeOut('slow')
    ;
});

// Define confirmation and action through data-confirm and data-action attributes
$(document).on('click', "input[data-confirm]", function() {
    if (confirm($(this).attr('data-confirm'))) {
        $('<form>') // create new form
            .attr('method', 'post') // post method
            .attr('action', $(this).attr('data-action')) // set action url
            .submit(); // submit
    }
});

// Validate the HTMl5 required attribute
$(document).on('submit', 'form', function() {
    var errors = $(this).find('input[required]') // get all required input fields
        .removeClass('invalid') // if revalidating, remove error class
        .filter(function() { // filter empty fields
            return ($(this).val() == "");
        })
        .addClass('invalid') // add error class
        .size(); // count errors

    if (errors) {
        alert("Some required fields are empty");
    }

    return !errors;
});
