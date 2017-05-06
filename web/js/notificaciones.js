function obtenerNotificaciones() {
    $.get('/user/profile/notifications-ajax', function(data){
        populateNotifications(data);
    });
}

obtenerNotificaciones();

var populateNotifications = function(notificationData){
    var notificaciones = JSON.parse(notificationData);
    $('.notification-icon').attr('data-count', notificaciones.length);
    $('.dropdown-notifications-list').empty();

    if (notificaciones.length != 0) {
        $('.notification-icon').removeClass('hidden-icon').addClass('show-icon');

        $(notificaciones).each(function(index, item){

            if (item['type'] == 0) {
                // $('.dropdown-notifications-list').append('<li class="notification">'+
                // '<a href="/posts/' + item['post_id'] + '" class="notification-link" data-id='+
                // item['id']+'>Tu post "<i>'+item['titulo']+'</i>..." ha sido <b>aceptado</b>.</a></li>');
                $('.dropdown-notifications-list').append(`
                    <li class="notification">
                        <div class="media">
                            <div class="media-left">
                              <div class="media-object">
                                <i class="fa fa-exclamation fa-lg" aria-hidden="true"></i>
                              </div>
                            </div>
                            <div class="media-body">
                              <a href="/posts/` + item['post_id'] +
                              `" class="notification-link" data-id='`+item['id']+`'>
                              Tu post "<i>'`+item['titulo']+`'</i>..." ha sido <b>aceptado</b>.</a>

                              <!--<div class="notification-meta">
                                <small class="timestamp">`+item['created_at']+`</small>
                              </div>-->
                            </div>
                        </div>
                    </li>
                    `)
            }
        });
        $('.notification-link').on('click', function(e) {
            $.get('/user/profile/notifications-read-ajax', {id: $(this).attr('data-id')});
        });
    } else {
        $('.notification-icon').removeClass('show-icon').addClass('hidden-icon');
        $('.dropdown-notifications-list').append('<li class="notification">'+
        'No tienes ninguna notificación pendiente.</li>');
    }
}

setInterval(function(){
    obtenerNotificaciones()
}, 5000);

$('#notification-all-read').on('click', function(e) {
    e.preventDefault();
    $('.notification-icon').removeClass('show-icon').addClass('hidden-icon');

    $('.notification-icon').attr('data-count', 0);
    $('.dropdown-notifications-list').empty();
    $('.dropdown-notifications-list').append('<li class="notification">'+
    'No tienes ninguna notificación pendiente.</li>');

    $.get('/user/profile/notifications-read-ajax', {id: 0});
});
