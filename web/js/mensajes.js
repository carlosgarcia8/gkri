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
            var receptor_id = $('#messageform-receptor_id').val();

            if ($('div.conversation[data-id="'+receptor_id+'"]').length) {
                if ($('.message-contact-' + receptor_id).length) {
                    var padre = $('.messages');

                    var img = $('div.conversation[data-id="'+receptor_id+'"]').find('img').clone();
                    var imgUsuario = img.clone();
                    imgUsuario.attr('src', $('#imagen-avatar').find('img').attr('src'));

                    var elem = $('.template-oculto > .msg').clone();
                    var elemPadre = $('div.message-contact-'+receptor_id);

                    var username = $('#textarea-message').attr('data-username');

                    var hoy = new Date();

                    var fecha = hoy.getDate() + '/' + hoy.getMonth() + '/' + hoy.getYear() +
                        ' ' + hoy.getHours() + ':' + hoy.getMinutes() + ':' + hoy.getSeconds();

                    elem.addClass('msg-emisor');
                    elem.find('.msg-avatar-emisor').append(imgUsuario);
                    elem.find('.msg-header').append('<i class="fa fa-minus fa-fw" aria-hidden="true"></i>');
                    elem.find('.msg-header').append('<strong>' + username + '</strong>');
                    elem.find('small').html(fecha);

                    elem.find('p').html($('#messageform-texto').val());

                    elemPadre.append(elem);

                    padre.scrollTop(padre[0].scrollHeight);
                }
            } else {
                $('#trigger-messages-pjax').click();
            }

            $('#myModalNorm').modal('toggle');
            $('#message-create').show();
            $('#messageform-texto').val('');
        });
    });

    return false;
});

$('#mensajes-form .btn-enviar-mensaje').on('click', function (e) {
    e.preventDefault();
    e.stopPropagation();

    var texto = $('#textarea-message').val().trim();
    $('#textarea-message').val('');
    $(this).addClass('btn-disabled');

    var padre = $('.messages');

    var img = $('.conversation-active').find('img').clone();
    var imgUsuario = img.clone();
    imgUsuario.attr('src', $('#imagen-avatar').find('img').attr('src'));

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
        var elemPadre = $('div.message-contact-'+contact_id);

        elem.addClass('msg-emisor');
        elem.find('.msg-avatar-emisor').append(imgUsuario);
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
    if ($(this).val().trim().length > 255) {
        $(this).css('color', 'red');
        $('#mensajes-form .btn-enviar-mensaje').addClass('btn-disabled');
        return;
    } else {
        $(this).css('color', 'black');
    }
    if (event.keyCode === 13) {
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

eventosConversaciones();

$(document).on('pjax:success', function () {
    eventosConversaciones();
});

function eventosConversaciones() {
    $('.conversation').on('click', function () {

        $('.conversation').removeClass('conversation-active');
        $(this).addClass('conversation-active');

        var contact_id = $(this).attr('data-id');
        var contacto = $(this).find('h5').text();
        $('#textarea-message').attr('data-contact-id', contact_id);

        var img = $(this).find('img').clone();
        var imgUsuario = img.clone();
        imgUsuario.attr('src', $('#imagen-avatar').find('img').attr('src'));

        var elemPadre = $('div.message-contact-'+contact_id);
        var padre = $('.messages');
        padre.children().hide();

        if (elemPadre.length > 0) {
            elemPadre.show();
            $('#messages .modal-title').text(contacto);
            padre.scrollTop(padre[0].scrollHeight);
        } else {
            $.ajax({
                url: '/messages/obtener',
                type: 'GET',
                data: {contact_id: contact_id}
            })
            .success(function (data) {
                var messages = JSON.parse(data);

                $('#messages .modal-title').text(contacto);


                padre.append('<div class="message-contact-'+contact_id+'"></div>');
                elemPadre = $('div.message-contact-'+contact_id);

                for (var i = 0; i < messages.length; i++) {
                    var elem = $('.template-oculto > .msg').clone();
                    var imgc = img.clone();
                    var imgUsuarioc = imgUsuario.clone();

                    if (parseInt(contact_id) !== messages[i]['user_id']) {
                        elem.addClass('msg-emisor');
                        elem.find('.msg-avatar-emisor').append(imgUsuarioc);
                        elem.find('.msg-header').append('<i class="fa fa-minus fa-fw" aria-hidden="true"></i>');
                        elem.find('.msg-header').append('<strong>' + messages[i]['emisor'] + '</strong>');
                        elem.find('small').html(messages[i]['fecha']);
                    } else {
                        elem.addClass('msg-receptor');
                        elem.find('.msg-avatar-receptor').append(imgc);
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
}
