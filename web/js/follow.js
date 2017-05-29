$('.btn-seguir').on('click', function (e) {
    e.preventDefault();

    var id = $(this).attr('data-follow-id');

    $.get('/follows/follow', {follow_id: id}, function(data){
        $('.btn-seguir').addClass('btn-hide');
        $('.btn-siguiendo').removeClass('btn-hide');

        $('.followers-total').html(data);
    });
});

$('.btn-siguiendo').on({
    mouseover: function () {
        $(this).removeClass('btn-info').addClass('btn-danger').html('Dejar de Seguir');
    },
    mouseleave: function () {
        $(this).removeClass('btn-danger').addClass('btn-info').html('Siguiendo');
    }
});

$('.btn-siguiendo').on('click', function (e) {
    e.preventDefault();
    
    var id = $(this).attr('data-follow-id');

    $.get('/follows/unfollow', {follow_id: id}, function(data){
        $('.btn-siguiendo').addClass('btn-hide');
        $('.btn-seguir').removeClass('btn-hide');

        $('.followers-total').html(data);
    });
});
