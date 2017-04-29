$('.vote-up').on('click', function() {
    votar($(this).attr('data-id'), true);
});

$('.vote-down').on('click', function() {
    votar($(this).attr('data-id'), false);
});

function votar(id, positivo) {
    var parametros = {
        "id" : id,
        "positivo": positivo
    };

    var botonPositivo = $('.item-post-' + id).find('.vote-up');
    var botonNegativo = $('.item-post-' + id).find('.vote-down');
    var trigger;

    if (positivo) {
        trigger = botonPositivo;
    } else {
        trigger = botonNegativo;
    }

    $.ajax({
        data:  parametros,
        url:   '/posts/votar',
        type:  'get',
        success: function (data) {
            if (!isNaN(data)) {
                if (trigger === botonPositivo) {
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
                $('.votos-total-' + id).html(data + ' votos');
            }
        }
    });
}
