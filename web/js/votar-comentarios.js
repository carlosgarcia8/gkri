$('.comment-vote-up').on('click', function() {
    votarComentario($(this).attr('data-comment-id'), true);
});

$('.comment-vote-down').on('click', function() {
    votarComentario($(this).attr('data-comment-id'), false);
});

function votarComentario(id, positivo) {
    var parametros = {
        "id" : id,
        "positivo": positivo
    };

    var botonPositivo = $('#comment-' + id).find('.comment-vote-up');
    var botonNegativo = $('#comment-' + id).find('.comment-vote-down');
    var trigger;

    if (positivo) {
        trigger = botonPositivo;
    } else {
        trigger = botonNegativo;
    }


    $.ajax({
        data:  parametros,
        url:   '/comments/default/votar',
        type:  'get',
        success: function (data) {
            if (!isNaN(data)) {
                if (trigger == botonPositivo) {
                    botonNegativo.removeClass('voted-down');

                    if (botonPositivo.hasClass('voted-up')) {
                        botonPositivo.removeClass('voted-up');
                    } else {
                        botonPositivo.addClass('voted-up');
                    }
                } else {
                    botonPositivo.removeClass('voted-up');

                    if (botonNegativo.hasClass('voted-down')) {
                        botonNegativo.removeClass('voted-down');
                    } else {
                        botonNegativo.addClass('voted-down');
                    }
                }
                $('.comment-votos-total-' + id).html(data + ' votos');
            }
            $('.comment-votos-total-' + id).html(data + ' votos');
        }
    });
}

$('.comment-reply').on('click', function () {
    var username = $(this).parent().parent().prev().children('img').attr('alt');
    $('#commentmodel-content').val('@' + username + ' ');
});

$('#cancel-reply').on('click', function () {
    $('#commentmodel-content').val('');
});
