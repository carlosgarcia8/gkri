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
