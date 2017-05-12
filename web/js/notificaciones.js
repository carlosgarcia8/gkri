function NotificationElement(texto, icon, enlace, dataid, datatype) {
    this.texto = texto;
    this.icon = icon;
    this.enlace = enlace;
    this.dataid = dataid;
    this.datatype = datatype;
}

NotificationElement.prototype.getElement = function () {
    return `
        <li class="notification">
            <div class="media">
                <div class="media-left">
                  <div class="media-object">
                    `+this.icon+`
                  </div>
                </div>
                <div class="media-body">
                  <a href="` + this.enlace + `" class="notification-link" data-id='`+
                  this.dataid+`' data-type='`+this.datatype+`'>`+this.texto+`</a>
                  <!--<div class="notification-meta">
                    <small class="timestamp">+item['created_at']+</small>
                  </div>-->
                </div>
            </div>
        </li>
        `
};

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
                $('.dropdown-notifications-list')
                .append(new NotificationElement(
                    'Tu post "<i>'+item['titulo']+'</i>..." ha sido <b>aceptado</b>.',
                    '<i class="fa fa-exclamation fa-lg" aria-hidden="true"></i>',
                    '/posts/' + item['post_id'],
                    item['post_id'],
                    item['type']
                ).getElement())
            } else if (item['type'] == 1) {
                $('.dropdown-notifications-list')
                .append(new NotificationElement(
                    'Hay <b>votos nuevos</b> en tu post "<i>'+item['titulo']+'</i>...".',
                    '<i class="fa fa-thumbs-up fa-lg" aria-hidden="true"></i>',
                    '/posts/' + item['post_id'],
                    item['post_id'],
                    item['type']
                ).getElement())
            } else if (item['type'] == 2) {
                $('.dropdown-notifications-list')
                .append(new NotificationElement(
                    'Hay '+item['count']+' <b>comentarios nuevos</b> en tu post "<i>'+item['titulo']+'</i>...".',
                    '<i class="fa fa-comment fa-lg" aria-hidden="true"></i>',
                    '/posts/' + item['post_id'],
                    item['post_id'],
                    item['type']
                ).getElement())
            } else if (item['type'] == 3) {
                $('.dropdown-notifications-list')
                .append(new NotificationElement(
                    'El usuario <b>'+item['username']+'</b> ha comenzado a seguirte.',
                    '<i class="fa fa-user-plus fa-lg" aria-hidden="true"></i>',
                    '/u/' + item['username'],
                    item['user_related_id'],
                    item['type']
                ).getElement())
            } else if (item['type'] == 4) {
                $('.dropdown-notifications-list')
                .append(new NotificationElement(
                    'El usuario <b>'+item['username']+'</b> ha publicado un <b>post nuevo</b>.',
                    '<i class="fa fa-plus-square fa-lg" aria-hidden="true"></i>',
                    '/posts/' + item['post_id'],
                    item['post_id'],
                    item['type']
                ).getElement())
            } else if (item['type'] == 5) {
                $('.dropdown-notifications-list')
                .append(new NotificationElement(
                    'Hay '+item['count']+' nuevos <b> replies</b> a tu comentario en el post "<i>'+item['titulo']+'</i>...".',
                    '<i class="fa fa-commenting fa-lg" aria-hidden="true"></i>',
                    '/posts/' + item['post_id'],
                    item['post_id'],
                    item['type']
                ).getElement())
            }
        });
        $('.notification-link').on('click', function(e) {
            $.get('/user/profile/notifications-read-ajax', {
                type: $(this).attr('data-type'),
                id: $(this).attr('data-id')
            });
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

    $.get('/user/profile/notifications-read-ajax', {type: -1, id: 0});
});
