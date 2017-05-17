if (document.documentElement.scrollTop < 1200) {
    $('#btn-arriba').hide();
}
$('#btn-arriba').click(function(e){
    e.preventDefault();

    $('html,body').animate({ scrollTop: 0 }, 'slow');
    return false;
});
$(window).scroll(function() {
    console.log(document.documentElement.scrollTop);
    if ($(document).height() - $(window).height() > document.documentElement.scrollTop) {
        $('#btn-arriba').css('bottom', '40px');
    } else {
        $('#btn-arriba').css('bottom', '80px');
    }
    if (document.documentElement.scrollTop > 1200) {
        $('#btn-arriba').show();
    } else {
        $('#btn-arriba').hide();
    }
});
