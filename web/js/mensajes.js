$('#mensaje-form .btn-enviar-mensaje').on('click', function (e) {
    e.preventDefault();
    e.stopPropagation();

    var formData = new FormData($('#mensaje-form')[0]);

    $.ajax({
        url: '/messages/create',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false
    })
    .success(function() {
        $(function () {
           $('#myModalNorm').modal('toggle');
           $('#message-create').show();
        });
    });

    return false;
});

$('#mensajes-form .btn-enviar-mensaje').on('click', function (e) {
    e.preventDefault();
    e.stopPropagation();

    var texto = $('#textarea-message').val();
    $('#textarea-message').val('');
    $(this).addClass('btn-disabled');

    var padre = $('.messages');

    var contact_id = $('#textarea-message').attr('data-contact-id');
    var username = $('#textarea-message').attr('data-username');

    var hoy = new Date();

    var fecha = hoy.getDate() + '/' + hoy.getMonth() + '/' + hoy.getYear() +
        ' ' + hoy.getHours() + ':' + hoy.getMinutes() + ':' + hoy.getSeconds();

    $.ajax({
        url: '/messages/create',
        type: 'POST',
        data: {'MessageForm[texto]': texto, 'MessageForm[receptor_id]': contact_id}
    })
    .success(function() {
        var elem = $('.template-oculto > .msg').clone();
        var elemPadre = $('div.mensage-contact-'+contact_id);

        elem.addClass('msg-emisor');
        elem.find('.msg-header').append('<i class="fa fa-minus fa-fw" aria-hidden="true"></i>');
        elem.find('.msg-header').append('<strong>' + username + '</strong>');
        elem.find('small').html(fecha);

        elem.find('p').html(texto);

        elemPadre.append(elem);

        padre.scrollTop(padre[0].scrollHeight);
    });

    return false;
})

$('#message-create .close').on('click', function(e) {
    $(this).parent().hide();
});

$('#textarea-message').on('keyup keydown', function (event) {
    if (event.keyCode == 13) {
        if ($(this).val().trim().length > 0 && $(this).attr('data-contact-id')) {
            $('#mensajes-form .btn-enviar-mensaje').click();
            $('#mensajes-form .btn-enviar-mensaje').removeClass('btn-disabled');
        } else {
            $('#mensajes-form .btn-enviar-mensaje').addClass('btn-disabled');
        }
        return false;
     }

    if ($(this).val().trim().length > 0 && $(this).attr('data-contact-id')) {
        $('#mensajes-form .btn-enviar-mensaje').removeClass('btn-disabled');
    } else {
        $('#mensajes-form .btn-enviar-mensaje').addClass('btn-disabled');
    }
});

$('.conversation').on('click', function () {

    var contact_id = $(this).attr('data-id');
    var contacto = $(this).find('h5').text();
    $('#textarea-message').attr('data-contact-id', contact_id);

    var elemPadre = $('div.mensage-contact-'+contact_id);
    var padre = $('.messages');
    padre.children().hide();

    if (elemPadre.length > 0) {
        elemPadre.show();
        padre.scrollTop(padre[0].scrollHeight);
    } else {
        $.ajax({
            url: '/messages/obtener',
            type: 'GET',
            data: {contact_id: contact_id}
        })
        .success(function (data) {
            var messages = JSON.parse(data);

            $('#messages .contact-username').text(contacto);


            padre.append('<div class="mensage-contact-'+contact_id+'"></div>');
            elemPadre = $('div.mensage-contact-'+contact_id);

            for (var i = 0; i < messages.length; i++) {
                var elem = $('.template-oculto > .msg').clone();

                if (contact_id != messages[i]['user_id']) {
                    elem.addClass('msg-emisor');
                    elem.find('.msg-header').append('<i class="fa fa-minus fa-fw" aria-hidden="true"></i>');
                    elem.find('.msg-header').append('<strong>' + messages[i]['emisor'] + '</strong>');
                    elem.find('small').html(messages[i]['fecha']);
                } else {
                    elem.addClass('msg-receptor');
                    elem.find('.msg-header').prepend('<i class="fa fa-minus fa-fw" aria-hidden="true"></i>');
                    elem.find('.msg-header').prepend('<strong>' + messages[i]['emisor'] + '</strong>');
                    elem.find('small').html(messages[i]['fecha']);
                }

                elem.find('p').html(messages[i]['texto']);

                elemPadre.prepend(elem);
            }
            padre.scrollTop(padre[0].scrollHeight);

        });
    }
});
