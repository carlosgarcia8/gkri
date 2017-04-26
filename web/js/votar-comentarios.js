$('.comment-vote-up').on('click', function() {
    votarComentario($(this).attr('alt'), true);

    $(this).parent().next().find('a').removeClass('voted-down');

    if ($(this).hasClass('voted-up')) {
        $(this).removeClass('voted-up');
    } else {
        $(this).addClass('voted-up');
    }
});

$('.comment-vote-down').on('click', function() {
    votarComentario($(this).attr('alt'), false);

    $(this).parent().prev().find('a').removeClass('voted-up');

    if ($(this).hasClass('voted-down')) {
        $(this).removeClass('voted-down');
    } else {
        $(this).addClass('voted-down');
    }
});

function votarComentario(id, positivo) {
    var parametros = {
        "id" : id,
        "positivo": positivo
    };
    $.ajax({
        data:  parametros,
        url:   '/comments/default/votar',
        type:  'get',
        success: function (data) {
            $('.comment-votos-total-' + id).html(data + ' votos');
        }
    });
}

$('.comment-reply').on('click', function () {
    var username = $(this).parent().parent().prev().children('img').attr('alt');
    $('#commentmodel-content').val('@' + username + ' ');
});
