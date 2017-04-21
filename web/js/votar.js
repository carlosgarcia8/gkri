$('.vote-up').on('click', function() {
    votar($(this).attr('alt'), true);

    $(this).parent().next().find('a').removeClass('voted-down');

    if ($(this).hasClass('voted-up')) {
        $(this).removeClass('voted-up');
    } else {
        $(this).addClass('voted-up');
    }
});

$('.vote-down').on('click', function() {
    votar($(this).attr('alt'), false);

    $(this).parent().prev().find('a').removeClass('voted-up');

    if ($(this).hasClass('voted-down')) {
        $(this).removeClass('voted-down');
    } else {
        $(this).addClass('voted-down');
    }
});

function votar(id, positivo) {
    var parametros = {
        "id" : id,
        "positivo": positivo
    };
    $.ajax({
        data:  parametros,
        url:   '/posts/votar',
        type:  'get',
        success: function (data) {
            $('.votos-total-' + id).html(data + ' votos');
        }
    });
}
