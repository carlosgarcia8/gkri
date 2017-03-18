$('.upload').click(function(){
    $('input[type=file]').click();
    return false;
});

$(".uploadAvatar").change(function() {
    this.form.submit();
});

$('#imagen-avatar').next().addClass('dropdown-menu-left');
