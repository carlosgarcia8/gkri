$('#upload-post-form').on('afterValidate', function (event, messages, errorAttributes) {
    var valido = true;
    $(errorAttributes).each(function (key, attribute) {
        if (attribute.name === 'titulo' || attribute.name === 'imageFile') {
            valido = false;
        }
    });
    if (valido) {
        $(this).hide();
        $('div.post-form-spinner').html('<span class="fa fa-spinner fa-pulse fa-3x fa-fw"></span> Subiendo...');
    }
});
