Mercury.on('ready', function() {
    Mercury.config.uploading.url = $('meta[name=mercury-images]').attr('content');
    // Enable Mercury after clicking in a mercury region
    $('#mercury_iframe').contents().one('click', "[contenteditable=false]", function() {
        Mercury.trigger('toggle:interface');
    });
});

Mercury.config.toolbars.primary.sep10 = '-';
Mercury.config.toolbars.primary.page = {
    newPage: ['New Page', 'Create a new page', {modal: $('meta[name=mercury-new]').attr('content')}],
    editPage: ['Edit Page', 'Edit page settings', {modal: $('meta[name=mercury-edit]').attr('content')}],
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
