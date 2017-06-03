$('#upload-post-form').on('afterValidate', function (event, messages, errorAttributes) {
    var valido = true;
    $(errorAttributes).each(function (key, attribute) {
        if (attribute.name === 'titulo' || attribute.name === 'imageFile') {
            valido = false;
        }
    });
    if (valido) {
        $(this).hide();
        $('#modal-upload').find('h3').hide();
        $('#modal-upload').find('.botones-upload').hide();
        $('div.post-form-spinner').html('<span class="fa fa-spinner fa-pulse fa-2x fa-fw"></span> Subiendo...');
    }
});
