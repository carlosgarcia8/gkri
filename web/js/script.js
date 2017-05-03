$('.upload').click(function(){
    $('input[type=file]').click();
    return false;
});
// TODO validar que no excede el peso antes de hacer submit, sino explota
$(".uploadAvatar").change(function() {
    this.form.submit();
});

$('#imagen-avatar').next().addClass('dropdown-menu-left');
