$('.upload').click(function(){
    $('input[type=file]').click();
    return false;
});
$(".uploadAvatar").change(function() {
    if (this.files.length !== 0) {
        if ((this.files[0].size / 1048576) <= 2) {
            if (this.files[0].type === 'image/jpeg' || this.files[0].type === 'image/png') {
                this.form.submit();
            } else {
                $('#upload-client-error').find('span').text('El formato del archivo no está permitido. Debe ser una imagen con extensión jpeg o png.');
                $('#upload-client-error').show();
            }
        } else if (this.files[0].type === 'image/jpeg' || this.files[0].type === 'image/png'){
            $('#upload-client-error').find('span').text('El peso del fichero no debe sobrepasar los 2 Mb.');
            $('#upload-client-error').show();
        } else {
            $('#upload-client-error').find('span').text('El formato del archivo no está permitido. Debe ser una imagen con extensión jpeg o png. El peso del fichero no debe sobrepasar los 2 Mb.');
            $('#upload-client-error').show();
        }
    }
});

$('#upload-client-error').find('.close').on('click', function () {
    $('#upload-client-error').hide();
});

$('#imagen-avatar').next().addClass('dropdown-menu-left');
