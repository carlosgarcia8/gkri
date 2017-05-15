$('.btn-enviar-mensaje').on('click', function (e) {
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

$('#message-create .close').on('click', function(e) {
    $(this).parent().hide();
});

$('.conversation').on('click', function () {

    var contact_id = $(this).attr('data-id');

    $.ajax({
        url: '/messages/obtener',
        type: 'GET',
        data: {contact_id: contact_id}
    })
    .success(function (data) {
        var messages = JSON.parse(data);

        var padre = $('.messages');
        padre.empty();

        for (var i = 0; i < messages.length; i++) {
            var elem = $('.template-oculto > .msg').clone();

            if (contact_id == messages[i]['user_id']) {
                elem.addClass('msg-emisor');
                elem.find('.msg-header').append('<i class="fa fa-minus fa-fw" aria-hidden="true"></i>');
                elem.find('.msg-header').append('<strong>' + messages[i]['emisor'] + '</strong>');
                elem.find('small').html(messages[i]['fecha']);
            } else {
                elem.addClass('msg-receptor');
                elem.find('.msg-header').prepend('<i class="fa fa-minus fa-fw" aria-hidden="true"></i>');
                elem.find('.msg-header').prepend('<strong>' + messages[i]['receptor'] + '</strong>');
                elem.find('small').html(messages[i]['fecha']);
            }

            elem.find('p').html(messages[i]['texto']);

            padre.prepend(elem);
        }
        padre.scrollTop(padre[0].scrollHeight);
    });
});
