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

                    var fecha = obtenerFecha();

                    elem.addClass('msg-emisor');
                    elem.find('.msg-avatar-emisor').append(imgUsuario);
                    elem.find('.msg-header').append('<span class="fa fa-minus fa-fw" aria-hidden="true"></span>');
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

    var fecha = obtenerFecha();

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
        elem.find('.msg-header').append('<span class="fa fa-minus fa-fw" aria-hidden="true"></span>');
        elem.find('.msg-header').append('<strong>' + username + '</strong>');
        elem.find('small').html(fecha);

        elem.find('p').html(texto);

        elemPadre.append(elem);

        padre.scrollTop(padre[0].scrollHeight);

        $('#trigger-messages-pjax').click();
    });

    return false;
});

function obtenerFecha() {
    var hoy = new Date();
    var fecha = '';

    if (hoy.getDate() < 10) {
        fecha += '0' + hoy.getDate();
    } else {
        fecha += hoy.getDate();
    }

    fecha = fecha + '/';

    if (hoy.getMonth() + 1 < 10) {
        fecha += '0' + (hoy.getMonth() + 1);
    } else {
        fecha += hoy.getMonth();
    }

    fecha = fecha + '/' + hoy.getFullYear() + ' ';

    if (hoy.getHours() < 10) {
        fecha += '0' + hoy.getHours();
    } else {
        fecha += hoy.getHours();
    }

    fecha = fecha + ':';

    if (hoy.getMinutes() < 10) {
        fecha += '0' + hoy.getMinutes();
    } else {
        fecha += hoy.getMinutes();
    }

    fecha = fecha + ':';

    if (hoy.getSeconds() < 10) {
        fecha += '0' + hoy.getSeconds();
    } else {
        fecha += hoy.getSeconds();
    }
    return fecha;
}

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
    var messages_activo = $('.messages').children(':visible').attr('data-contact-id');

    $('.conversaciones').children('.conversation[data-id="'+messages_activo+'"]').addClass('conversation-active');
});

estaMensajesAjax = false;

function mensajesAjax() {
    estaMensajesAjax = true;

    var mensajesDiv = $('.messages').children();

    var contactos_activos = new Array(mensajesDiv.length);

    mensajesDiv.each(function(index, el) {
        contactos_activos[index] = [$(el).attr('data-contact-id'), $(el).children('.msg-receptor').last().attr('data-m-id')];
    });

    contactos_activos = JSON.stringify(contactos_activos);

    $.ajax({
        url: '/messages/obtener-nuevos',
        type: 'GET',
        data: {contactos_activos: contactos_activos}
    })
    .success(function (data) {
        var messages = JSON.parse(data);

        for (var i = 0; i < messages.length; i++) {
            var elem = $('.template-oculto > .msg').clone();
            var conver = $('.conversation[data-id="'+messages[i]['user_id']+'"]');
            var imgc = $(conver).find('img').clone();

            var converMessages = $('.message-contact-' + messages[i]['user_id']);

            elem.addClass('msg-receptor').attr('data-m-id', messages[i]['id']);
            elem.find('.msg-avatar-receptor').append(imgc);
            elem.find('.msg-header').prepend('<span class="fa fa-minus fa-fw" aria-hidden="true"></span>');
            elem.find('.msg-header').prepend('<strong>' + messages[i]['emisor'] + '</strong>');
            elem.find('small').html(messages[i]['fecha']);

            elem.find('p').html(messages[i]['texto']);

            converMessages.append(elem);

            var padre = $('.messages');
            padre.scrollTop(padre[0].scrollHeight);
        }

        $('#trigger-messages-pjax').click();
    });
}

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
            $('#messages .modal-title').html('<a href="/u/'+contacto+'" >'+contacto+'</a>');
            padre.scrollTop(padre[0].scrollHeight);
        } else {
            $.ajax({
                url: '/messages/obtener',
                type: 'GET',
                data: {contact_id: contact_id}
            })
            .success(function (data) {
                var messages = JSON.parse(data);

                $('#messages .modal-title').html('<a href="/u/'+contacto+'" >'+contacto+'</a>');


                padre.append('<div class="message-contact-'+contact_id+'" data-contact-id="'+contact_id+'"></div>');
                elemPadre = $('div.message-contact-'+contact_id);

                for (var i = 0; i < messages.length; i++) {
                    var elem = $('.template-oculto > .msg').clone();
                    var imgc = img.clone();
                    var imgUsuarioc = imgUsuario.clone();

                    if (parseInt(contact_id) !== messages[i]['user_id']) {
                        elem.addClass('msg-emisor').attr('data-m-id', messages[i]['id']);
                        elem.find('.msg-avatar-emisor').append(imgUsuarioc);
                        elem.find('.msg-header').append('<span class="fa fa-minus fa-fw" aria-hidden="true"></span>');
                        elem.find('.msg-header').append('<strong>' + messages[i]['emisor'] + '</strong>');
                        elem.find('small').html(messages[i]['fecha']);
                    } else {
                        elem.addClass('msg-receptor').attr('data-m-id', messages[i]['id']);
                        elem.find('.msg-avatar-receptor').append(imgc);
                        elem.find('.msg-header').prepend('<span class="fa fa-minus fa-fw" aria-hidden="true"></span>');
                        elem.find('.msg-header').prepend('<strong>' + messages[i]['emisor'] + '</strong>');
                        elem.find('small').html(messages[i]['fecha']);
                    }

                    elem.find('p').html(messages[i]['texto']);

                    elemPadre.prepend(elem);
                }
                padre.scrollTop(padre[0].scrollHeight);

                if (!estaMensajesAjax) {
                    setInterval(function(){
                        mensajesAjax();
                    }, 8000);
                }
            });
        }
    });
}
