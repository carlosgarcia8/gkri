if ($(document).scrollTop() < 1200) {
    $('#btn-arriba').hide();
}
$('#btn-arriba').click(function(e){
    e.preventDefault();

    $('html,body').animate({ scrollTop: 0 }, 'slow');
    return false;
});
// TODO firefox da un warning por el scroll, comprobar que es
$(window).scroll(function() {

    if ($(document).height() - $(window).height() > $(document).scrollTop()) {
        $('#btn-arriba').css('bottom', '40px');
    } else {
        $('#btn-arriba').css('bottom', '80px');
    }
    if ($(document).scrollTop() > 1200) {
        $('#btn-arriba').show();
    } else {
        $('#btn-arriba').hide();
    }
});
