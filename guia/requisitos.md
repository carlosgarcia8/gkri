Catálogo de Requisitos
==================


### <a name="definicion-detallada">Definición detallada</a>

[Ir a Cuadro resumen](#cuadro-resumen)

| R01 | Registrar un usuario
| -------------|-----|
| Descripción larga | El usuario entrara en la aplicación y por medio de un formulario donde le pedirá email, nombre y contraseña se registrara. Al registrarse se le enviara un correo a su email para que confirme el mismo.
| Prioridad | Importante
| Tipo | Funcional
| Complejidad | Fácil
| Entrega planificada | v1
| Entrega Realizada | v1
| Nº incidencia | [1](https://github.com/carlosgarcia8/gkri/issues/1)

| R02 | Iniciar sesión
| -------------|-----|
| Descripción larga | El usuario podrá iniciar sesión tanto con el correo como con el  username. También se podrá logear con google+.
| Prioridad | Importante
| Tipo | Funcional
| Complejidad | Fácil
| Entrega planificada | v1
| Entrega Realizada | v1
| Nº incidencia | [2](https://github.com/carlosgarcia8/gkri/issues/2)

| R03 | Mostrar los Posts
| -------------|-----|
| Descripción larga | Se mostraran el autor, el titulo, la imagen, la categoría, cuantos votos  positivos tiene y unos botones de voto positivo y negativo. Irán de la  misma manera que la web  http://9gag.com , y si nos vamos a un post  en concreto nos mostrara la misma información mas los comentarios.
| Prioridad | Importante
| Tipo | Funcional
| Complejidad | Fácil
| Entrega planificada | v1
| Entrega Realizada | v1
| Nº incidencia | [3](https://github.com/carlosgarcia8/gkri/issues/3)

| R04 | Borrar un post
| -------------|-----|
| Descripción larga | En la propia sección del post subido por el usuario tendrá la opción  “delete” donde eliminara su post. El admin siempre tendrá la opción de  borrar cualquier post de la aplicación.
| Prioridad | Importante
| Tipo | Funcional
| Complejidad | Fácil
| Entrega planificada | v1
| Entrega Realizada | v1
| Nº incidencia | [4](https://github.com/carlosgarcia8/gkri/issues/4)

| R05 | Crear un post
| -------------|-----|
| Descripción larga | Un botón nos llevara a un formulario el cual hará falta rellenar con  titulo, la categoría y una imagen. La imagen deberá de controlarse un mínimo de altura y anchura correspondiente con el estilo de la  aplicación, unas extensiones permitidas y una redimension que hará la aplicación. El post se quedara en un estado de “pendiente de  moderación”, hasta que un admin no lo apruebe no pasara a la página  principal. Las imágenes que se suben podrán ser imágenes largas verticalmente por lo cual se recortaran y se le especificara al usuario que para verlo deberá de entrar en su apartado, imágenes normales en cuanto dimensión y gifs. Todas las imágenes se tendrán que re-dimensionar para que tengan la misma anchura.
| Prioridad | Importante
| Tipo | Funcional
| Complejidad | Fácil
| Entrega planificada | v1
| Entrega Realizada | v1
| Nº incidencia | [5](https://github.com/carlosgarcia8/gkri/issues/5)

| R06 | Actualizar un post
| -------------|-----|
| Descripción larga | El usuario no tendrá permisos de actualización, pero el que tenga  permisos de admin si.
| Prioridad | Importante
| Tipo | Funcional
| Complejidad | Fácil
| Entrega planificada | v1
| Entrega Realizada | v1
| Nº incidencia | [6](https://github.com/carlosgarcia8/gkri/issues/6)

| R07 | Re dimensionar imagen del Post
| -------------|-----|
| Descripción larga | Las imágenes podrán ser tanto png, jpg como gif. Se re-dimensionaran a unas dimensiones correctas para el estilo de la aplicación,  seguramente todas deberán tener la misma anchura (unos 500px mas  o menos) y mantener el aspect ratio en cuanto a la altura.
| Prioridad | Importante
| Tipo | Funcional
| Complejidad | Media
| Entrega planificada | v1
| Entrega Realizada | v1
| Nº incidencia | [7](https://github.com/carlosgarcia8/gkri/issues/7)

| R08 | Re dimensionar gif del post
| -------------|-----|
| Descripción larga | Las imágenes podrán ser tanto png, jpg como gif. Se re-dimensionaran a unas dimensiones correctas para el estilo de la aplicación,  seguramente todas deberán tener la misma anchura (unos 500px mas o menos) y mantener el aspect ratio en cuanto a la altura.
| Prioridad | Importante
| Tipo | Funcional
| Complejidad | Alta
| Entrega planificada | v2
| Entrega Realizada | v2
| Nº incidencia | [31](https://github.com/carlosgarcia8/gkri/issues/31)

| R09 | Cambiar configuración de la cuenta del usuario
| -------------|-----|
| Descripción larga | El usuario podrá cambiar su correo, su contraseña y el username. La  aplicación le pedirá siempre la contraseña actual para poder hacer cualquier cambio en la configuración de la cuenta.
| Prioridad | Importante
| Tipo | Funcional
| Complejidad | Fácil
| Entrega planificada | v1
| Entrega Realizada | v1
| Nº incidencia | [8](https://github.com/carlosgarcia8/gkri/issues/8)

| R10 |  Cambiar configuración del perfil del usuario
| -------------|-----|
| Descripción larga | El usuario podrá cambiar su nombre, su género, su localización y una biografía. Esta información sera visible para todos.
| Prioridad | Importante
| Tipo | Funcional
| Complejidad | Fácil
| Entrega planificada | v1
| Entrega Realizada | v1
| Nº incidencia | [9](https://github.com/carlosgarcia8/gkri/issues/9)

| R11 | Cambiar avatar del usuario
| -------------|-----|
| Descripción larga | En la configuración del usuario tendrá la vista del avatar y un botón  para cambiar avatar. En el perfil del usuario si pasa el ratón por encima del avatar también le ofrecerá la posibilidad de cambiar el avatar  siempre y cuando sea su perfil.
| Prioridad | Importante
| Tipo | Funcional
| Complejidad | Fácil
| Entrega planificada | v1
| Entrega Realizada | v1
| Nº incidencia | [10](https://github.com/carlosgarcia8/gkri/issues/10)

| R12 | Re dimensionar imagen del avatar del usuario
| -------------|-----|
| Descripción larga | e re dimensionara para que tenga unas medidas correctas para el estilo de la aplicación.
| Prioridad | Importante
| Tipo | Funcional
| Complejidad | Fácil
| Entrega planificada | v1
| Entrega Realizada | v1
| Nº incidencia | [11](https://github.com/carlosgarcia8/gkri/issues/11)

| R13 | Comentar un post
| -------------|-----|
| Descripción larga | El usuario tendrá un espacio para poder escribir su comentario y luego dándole a un botón se añadirá ese comentario al post.
| Prioridad | Importante
| Tipo | Funcional
| Complejidad | Fácil
| Entrega planificada | v2
| Entrega Realizada | v2
| Nº incidencia | [32](https://github.com/carlosgarcia8/gkri/issues/32)

| R14 | Mostrar comentarios de un post
| -------------|-----|
| Descripción larga | Los comentarios se mostraran de tal manera que aquellos mas  votados se irán arriba y los menos votados o nuevo se quedaran  abajo. Los comentarios se mostraran con sus replies.
| Prioridad | Importante
| Tipo | Funcional
| Complejidad | Fácil
| Entrega planificada | v2
| Entrega Realizada | v2
| Nº incidencia | [33](https://github.com/carlosgarcia8/gkri/issues/33)

| R15 | Comentar otro comentario (reply)
| -------------|-----|
| Descripción larga | Los comentarios se podrán escribir haciendo reply a otros comentarios de tal manera que irán de arriba a abajo, en los comentarios se les  nombrara al usuario del comentario hecho reply (ejemplo: “@iesdonana jaja me gusto tu comentario”).
| Prioridad | Importante
| Tipo | Funcional
| Complejidad | Alta
| Entrega planificada | v2
| Entrega Realizada | v2
| Nº incidencia | [34](https://github.com/carlosgarcia8/gkri/issues/34)

| R16 | Borrar comentario siendo usuario
| -------------|-----|
| Descripción larga | El usuario podrá eliminar el comentario siempre y cuando no tengan ningún reply por medio de un botón “delete”.
| Prioridad | Importante
| Tipo | Funcional
| Complejidad | Fácil
| Entrega planificada | v2
| Entrega Realizada | v2
| Nº incidencia | [35](https://github.com/carlosgarcia8/gkri/issues/35)

| R17 | Moderación de posts
| -------------|-----|
| Descripción larga | Los admins deberán de entrar en dicha sección y aprobar aquellos  posts que cumplan con los principios éticos y morales y rechazar a aquellos que no los cumplan.
| Prioridad | Importante
| Tipo | Funcional
| Complejidad | Fácil
| Entrega planificada | v2
| Entrega Realizada | v1
| Nº incidencia | [36](https://github.com/carlosgarcia8/gkri/issues/36)

| R18 | Votar positivo un post
| -------------|-----|
| Descripción larga | El usuario al pulsar sobre un botón le dará un voto positivo al post y se  actualizara usando ajax el numero de votos y el color/forma del botón. Si le vuelve a dar le quitara el voto positivo.
| Prioridad | Importante
| Tipo | Funcional
| Complejidad | Fácil
| Entrega planificada | v2
| Entrega Realizada | v2
| Nº incidencia | [37](https://github.com/carlosgarcia8/gkri/issues/37)

| R19 | Votar negativo un post
| -------------|-----|
| Descripción larga | El usuario al pulsar sobre un botón le dará un voto negativo al post y se actualizara usando ajax el numero de votos y el color/forma del botón. Si le vuelve a dar le quitara el voto negativo.
| Prioridad | Importante
| Tipo | Funcional
| Complejidad | Fácil
| Entrega planificada | v2
| Entrega Realizada | v2
| Nº incidencia | [38](https://github.com/carlosgarcia8/gkri/issues/38)

| R20 | Votar positivo un comentario
| -------------|-----|
| Descripción larga | El usuario al pulsar sobre un botón le dará un voto positivo al comentario y se actualizara usando ajax el numero de votos y el  color/forma del botón. Si le vuelve a dar le quitara el voto positivo.
| Prioridad | Importante
| Tipo | Funcional
| Complejidad | Fácil
| Entrega planificada | v2
| Entrega Realizada | v2
| Nº incidencia | [39](https://github.com/carlosgarcia8/gkri/issues/39)

| R21 | Votar negativo un comentario
| -------------|-----|
| Descripción larga | El usuario al pulsar sobre un botón le dará un voto negativo al comentario y se actualizara usando ajax el numero de votos y el color/forma del botón. Si le vuelve a dar le quitara el voto negativo.
| Prioridad | Importante
| Tipo | Funcional
| Complejidad | Fácil
| Entrega planificada | v2
| Entrega Realizada | v2
| Nº incidencia | [40](https://github.com/carlosgarcia8/gkri/issues/40)

| R22 | El usuario puede seguir a otro usuarios
| -------------|-----|
| Descripción larga | Al seguir a otro usuario se te notificara cuando ese usuario ha subido un post.
| Prioridad | Opcional
| Tipo | Funcional
| Complejidad | Media
| Entrega planificada | v3
| Entrega Realizada | v3
| Nº incidencia | [70](https://github.com/carlosgarcia8/gkri/issues/70)

| R23 | El usuario puede tener seguidores
| -------------|-----|
| Descripción larga | Es un sistema a lo twitter, se te notifica que tal persona te sigue y tendrás en tu perfil un contador con toda la gente que sigue y a cuantos sigues tu.
| Prioridad | Opcional
| Tipo | Funcional
| Complejidad | Media
| Entrega planificada | v3
| Entrega Realizada | v3
| Nº incidencia | [71](https://github.com/carlosgarcia8/gkri/issues/71)

| R24 | Notificación de comentario
| -------------|-----|
| Descripción larga | Un post subido por el usuario cuando tenga un comentario nuevo le aparecerá un mensaje al usuario a través de ajax diciéndole “El post ‘ole’ tiene comentarios nuevos”.
| Prioridad | Importante
| Tipo | Funcional
| Complejidad | Media
| Entrega planificada | v3
| Entrega Realizada | v3
| Nº incidencia | [72](https://github.com/carlosgarcia8/gkri/issues/72)

| R25 | notificación de reply
| -------------|-----|
| Descripción larga | En un comentario realizado en un post cuando te hagan un reply y te nombren se te notificara.
| Prioridad | Opcional
| Tipo | Funcional
| Complejidad | Media
| Entrega planificada | v3
| Entrega Realizada | v3
| Nº incidencia | [73](https://github.com/carlosgarcia8/gkri/issues/73)

| R26 | Notificación de post nuevo
| -------------|-----|
| Descripción larga | Cuando un usuario de los que sigues suba un nuevo post se le notificara al usuario.
| Prioridad | Opcional
| Tipo | Funcional
| Complejidad | Media
| Entrega planificada | v3
| Entrega Realizada | v3
| Nº incidencia | [74](https://github.com/carlosgarcia8/gkri/issues/74)

| R27 | Notificación de seguidor nuevo
| -------------|-----|
| Descripción larga | Cuando tengas un seguidor nuevo se te notificara con esa información.
| Prioridad | Opcional
| Tipo | Funcional
| Complejidad | Media
| Entrega planificada | v3
| Entrega Realizada | v3
| Nº incidencia | [75](https://github.com/carlosgarcia8/gkri/issues/75)

| R28 | Notificación de votos en tu post
| -------------|-----|
| Descripción larga | Cuando haya votos tanto positivos como negativos se te notificara con que hay cambios en los votos del post.
| Prioridad | Importante
| Tipo | Funcional
| Complejidad | Media
| Entrega planificada | v3
| Entrega Realizada | v3
| Nº incidencia | [76](https://github.com/carlosgarcia8/gkri/issues/76)

| R29 | Notificación de post aceptado
| -------------|-----|
| Descripción larga | Cuando el post que hayas subido haya sido aceptado por un admin y por lo tanto ya vaya a la página principal, se te notificara.
| Prioridad | Importante
| Tipo | Funcional
| Complejidad | Media
| Entrega planificada | v3
| Entrega Realizada | v3
| Nº incidencia | [77](https://github.com/carlosgarcia8/gkri/issues/77)

| R30 | Logout del usuario
| -------------|-----|
| Descripción larga | Podrá finalizar sesión cuando quiera simplemente pulsando el botón ‘Logout’.
| Prioridad | Importante
| Tipo | Funcional
| Complejidad | Fácil
| Entrega planificada | v1
| Entrega Realizada | v1
| Nº incidencia | [12](https://github.com/carlosgarcia8/gkri/issues/12)

| R31 | Recordar usuario
| -------------|-----|
| Descripción larga | La aplicación recordara al usuario si así lo desea y así no tendrá por que volver a iniciar sesión.
| Prioridad | Importante
| Tipo | Funcional
| Complejidad | Fácil
| Entrega planificada | v1
| Entrega Realizada | v1
| Nº incidencia | [13](https://github.com/carlosgarcia8/gkri/issues/13)

| R32 | Ver todos los usuarios
| -------------|-----|
| Descripción larga | El admin podrá ver y realizar una serie de acciones con los usuarios registrados en la aplicación.
| Prioridad | Importante
| Tipo | Funcional
| Complejidad | Fácil
| Entrega planificada | v1
| Entrega Realizada | v1
| Nº incidencia | [14](https://github.com/carlosgarcia8/gkri/issues/14)

| R33 | Confirmar un usuario
| -------------|-----|
| Descripción larga | El admin podrá ver y realizar una serie de acciones con los usuarios registrados en la aplicación.
| Prioridad | Importante
| Tipo | Funcional
| Complejidad | Fácil
| Entrega planificada | v1
| Entrega Realizada | v1
| Nº incidencia | [15](https://github.com/carlosgarcia8/gkri/issues/15)

| R34 | Convertirse en un usuario
| -------------|-----|
| Descripción larga | El admin podrá entrar como ese usuario.
| Prioridad | Importante
| Tipo | Funcional
| Complejidad | Fácil
| Entrega planificada | v1
| Entrega Realizada | v1
| Nº incidencia | [16](https://github.com/carlosgarcia8/gkri/issues/16)

| R35 | Bloquear usuario
| -------------|-----|
| Descripción larga | El admin podrá bloquear cualquier usuario que el quiera de la lista.
| Prioridad | Importante
| Tipo | Funcional
| Complejidad | Fácil
| Entrega planificada | v1
| Entrega Realizada | v1
| Nº incidencia | [17](https://github.com/carlosgarcia8/gkri/issues/17)

| R36 | Generar nueva contraseña
| -------------|-----|
| Descripción larga | El admin podrá generar nueva contraseña para el usuario y se le enviara por correo.
| Prioridad | Importante
| Tipo | Funcional
| Complejidad | Fácil
| Entrega planificada | v1
| Entrega Realizada | v1
| Nº incidencia | [18](https://github.com/carlosgarcia8/gkri/issues/18)

| R37 | Crear nuevo usuario
| -------------|-----|
| Descripción larga | El admin podrá crear nuevo usuario rellenando el mismo formulario con correo, username y contraseña.
| Prioridad | Importante
| Tipo | Funcional
| Complejidad | Fácil
| Entrega planificada | v1
| Entrega Realizada | v1
| Nº incidencia | [19](https://github.com/carlosgarcia8/gkri/issues/19)

| R38 | Eliminar un usuario
| -------------|-----|
| Descripción larga | El admin podrá eliminar un usuario de la lista.
| Prioridad | Importante
| Tipo | Funcional
| Complejidad | Fácil
| Entrega planificada | v1
| Entrega Realizada | v1
| Nº incidencia | [20](https://github.com/carlosgarcia8/gkri/issues/20)

| R39 | Actualizar un usuario
| -------------|-----|
| Descripción larga | El admin podrá cambiar los datos de cualquier usuario en un menu parecido al que tiene el usuario pero con mas información.
| Prioridad | Importante
| Tipo | Funcional
| Complejidad | Fácil
| Entrega planificada | v1
| Entrega Realizada | v1
| Nº incidencia | [21](https://github.com/carlosgarcia8/gkri/issues/21)

| R40 | Mandar email de confirmación
| -------------|-----|
| Descripción larga | Básicamente la aplicación enviando un enlace al correo del usuario hará que ese usuario este confirmado y ya pueda iniciar sesión o cambiar su contraseña.
| Prioridad | Importante
| Tipo | Funcional
| Complejidad | Fácil
| Entrega planificada | v1
| Entrega Realizada | v1
| Nº incidencia | [22](https://github.com/carlosgarcia8/gkri/issues/22)

| R41 | Volver a enviar mensaje de confirmación
| -------------|-----|
| Descripción larga | La aplicación podrá enviar al correo del usuario el enlace de confirmación de nuevo en el caso de que lo haya perdido o extraviado.
| Prioridad | Importante
| Tipo | Funcional
| Complejidad | Fácil
| Entrega planificada | v1
| Entrega Realizada | v1
| Nº incidencia | [23](https://github.com/carlosgarcia8/gkri/issues/23)

| R42 | Borrar usuarios no confirmados
| -------------|-----|
| Descripción larga | La aplicación eliminara aquellos usuarios que en el plazo de 24 horas no hayan confirmado su email.
| Prioridad | Importante
| Tipo | Funcional
| Complejidad | Fácil
| Entrega planificada | v1
| Entrega Realizada | v1
| Nº incidencia | [24](https://github.com/carlosgarcia8/gkri/issues/24)

| R43 | Recuperar contraseña
| -------------|-----|
| Descripción larga | El usuario si no se acuerda de su contraseña siempre tiene la opción de recuperar la contraseña, donde le enviaran un enlace al correo para que pueda asignar una nueva contraseña. Este enlace solo estará disponible por 6 horas.
| Prioridad | Importante
| Tipo | Funcional
| Complejidad | Fácil
| Entrega planificada | v1
| Entrega Realizada | v1
| Nº incidencia | [25](https://github.com/carlosgarcia8/gkri/issues/25)

| R44 | Enviar mensaje privado a otro usuario
| -------------|-----|
| Descripción larga | El usuario podrá tener la opción en el perfil de otro usuario de mandarle un mensaje privado.
| Prioridad | Opcional
| Tipo | Funcional
| Complejidad | Fácil
| Entrega planificada | v3
| Entrega Realizada | v3
| Nº incidencia | [78](https://github.com/carlosgarcia8/gkri/issues/78)

| R45 | Crear mensaje privado
| -------------|-----|
| Descripción larga | El usuario al seleccionar que quiere mandarle un mensaje privado a otro usuario se le redirigirá a un formulario donde tendrá que rellenar un texto con el mensaje.
| Prioridad | Opcional
| Tipo | Funcional
| Complejidad | Fácil
| Entrega planificada | v3
| Entrega Realizada | v3
| Nº incidencia | [79](https://github.com/carlosgarcia8/gkri/issues/79)

| R46 | Eliminar mensaje privado
| -------------|-----|
| Descripción larga | El usuario podrá eliminar un mensaje privado enviado a otro usuario al ver los mensajes privados enviados.
| Prioridad | Opcional
| Tipo | Funcional
| Complejidad | Fácil
| Entrega planificada | v3
| Entrega Realizada |
| Nº incidencia | [80](https://github.com/carlosgarcia8/gkri/issues/80)

| R47 | Recibir mensaje privado de otro usuario
| -------------|-----|
| Descripción larga | El usuario tendrá la opción de recibir mensajes privados de otros usuarios.
| Prioridad | Opcional
| Tipo | Funcional
| Complejidad | Fácil
| Entrega planificada | v3
| Entrega Realizada | v3
| Nº incidencia | [81](https://github.com/carlosgarcia8/gkri/issues/81)

| R48 | Ver mensajes privados recibidos
| -------------|-----|
| Descripción larga | El usuario en su perfil tendrá la opción de ver todos los mensajes privados recibidos.
| Prioridad | Opcional
| Tipo | Funcional
| Complejidad | Fácil
| Entrega planificada | v3
| Entrega Realizada | v3
| Nº incidencia | [82](https://github.com/carlosgarcia8/gkri/issues/82)

| R49 | Ver mensajes privados enviados
| -------------|-----|
| Descripción larga | El usuario en su perfil tendrá la opción de ver todos los mensajes privados enviados.
| Prioridad | Opcional
| Tipo | Funcional
| Complejidad | Fácil
| Entrega planificada | v3
| Entrega Realizada | v3
| Nº incidencia | [83](https://github.com/carlosgarcia8/gkri/issues/83)

| R50 | Notificación de mensaje privado recibido
| -------------|-----|
| Descripción larga | Se le notificara al usuario cuando haya recibido un mensaje privado ensu inbox.
| Prioridad | Opcional
| Tipo | Funcional
| Complejidad | Media
| Entrega planificada | v3
| Entrega Realizada | v3
| Nº incidencia | [84](https://github.com/carlosgarcia8/gkri/issues/84)

| R51 | Generador de memes
| -------------|-----|
| Descripción larga | El usuario al querer crear un post se le dará la opción de subir una imagen de su ordenador o generarla por el generador de memes de la aplicación, la cual tendrá una serie de imágenes base y a la que tu selecciones te pedirá el texto de arriba y el texto de abajo (véase  http://memeful.com/generator). Una vez tenga el texto que quiera el usuario le podrá dar a upload, la aplicación generara la imagen con los textos, tendrá que rellenar el mismo formulario con titulo y demás y quedara pendiente de moderación.
| Prioridad | Opcional
| Tipo | Funcional
| Complejidad | Alta
| Entrega planificada | v3
| Entrega Realizada | v3
| Nº incidencia | [85](https://github.com/carlosgarcia8/gkri/issues/85)

| R52 | Mostrar un post en concreto
| -------------|-----|
| Descripción larga | Cuando se vean todos los posts al darle tanto a la imagen (cuando no sea un gif) o al titulo nos mandara al post en concreto donde ya veremos toda su información de otra manera junto a los comentarios.
| Prioridad | Importante
| Tipo | Funcional
| Complejidad | Fácil
| Entrega planificada | v1
| Entrega Realizada | v1
| Nº incidencia | [26](https://github.com/carlosgarcia8/gkri/issues/26)

| R53 | Buscar posts por categoría
| -------------|-----|
| Descripción larga | En el menú tendremos las distintas categorías disponibles y al pulsarlas nos mostrara los posts de esa categoría seleccionada.
| Prioridad | Importante
| Tipo | Funcional
| Complejidad | Fácil
| Entrega planificada | v1
| Entrega Realizada | v1
| Nº incidencia | [27](https://github.com/carlosgarcia8/gkri/issues/27)

| R54 | Buscar posts por título
| -------------|-----|
| Descripción larga | n el menú habrá un buscador donde al darle a buscar se mostraran los posts donde el titulo empiece por el texto que se haya buscado.
| Prioridad | Importante
| Tipo | Funcional
| Complejidad | Fácil
| Entrega planificada | v1
| Entrega Realizada | v1
| Nº incidencia | [28](https://github.com/carlosgarcia8/gkri/issues/28)

| R55 | Iniciar sesión por medio de Google+
| -------------|-----|
| Descripción larga | El usuario podrá iniciar sesión por google+ en el apartado login, solo tendrá que seleccionar que correo va a utilizar y darle permisos para poder obtener información a la aplicación.
| Prioridad | Importante
| Tipo | Funcional
| Complejidad | Fácil
| Entrega planificada | v1
| Entrega Realizada | v1
| Nº incidencia | [29](https://github.com/carlosgarcia8/gkri/issues/29)

| R56 | Guardar las variables de sesión en la base de datos
| -------------|-----|
| Descripción larga | La aplicación podrá guardar las variables de sesión en la base de datos para que así cuando este desplegada la aplicación pueda seguir manteniendo la sesión el usuario y no se pierda ese recordar que esta el usuario logeado.
| Prioridad | Importante
| Tipo | Funcional
| Complejidad | Fácil
| Entrega planificada | v1
| Entrega Realizada | v1
| Nº incidencia | [30](https://github.com/carlosgarcia8/gkri/issues/30)

| R57 | Uso de Amazon S3
| -------------|-----|
| Descripción larga | La aplicación guardara las imágenes y los videos/gifs que se suban en amazon s3, por tanto se tendrá que investigar como realizar esta subida y a la vez obtener los distintos archivos para luego mostrarlos.
| Prioridad | Importante
| Tipo | Funcional
| Complejidad | Alta
| Entrega planificada | v2
| Entrega Realizada | v1
| Nº incidencia | [41](https://github.com/carlosgarcia8/gkri/issues/41)

| R58 | Pausar y reanudar los distintos post
| -------------|-----|
| Descripción larga | Se investigara si existe algún plugin o se tendrá que realizar para poder ser mas interactivo el trato con los gifs/videos y así poder pausar los gifs e incluso mostrar los controles por los que se podrá ir hacia atrás o hacia delante. Para esto ultimo haría falta que su formato fuera mp4.
| Prioridad | Importante
| Tipo | Funcional
| Complejidad | Media
| Entrega planificada | v2
| Entrega Realizada | v2
| Nº incidencia | [42](https://github.com/carlosgarcia8/gkri/issues/42)

| R59 | Plugin para el generador de memes
| -------------|-----|
| Descripción larga | Habrá que investigar algún plugin el cual permita incrustar texto en las imágenes y así generarlas.
| Prioridad | Opcional
| Tipo | Funcional
| Complejidad | Alta
| Entrega planificada | v3
| Entrega Realizada | v3
| Nº incidencia | [86](https://github.com/carlosgarcia8/gkri/issues/86)

### Cuadro resumen

[Ir a Definición detallada](#definicion-detallada)

| Código | Descripción corta | Prioridad | Tipo | Complejidad | Entrega planificada | Entrega Realizada | Nº incidencia
|-----|-----|-----|-----|-----|-----|-----|-----|
| R01 | Registrar un usuario | Importante | Funcional | Fácil | v1 | v1 | [1](https://github.com/carlosgarcia8/gkri/issues/1) |
| R02 | Iniciar sesión | Importante | Funcional | Fácil | v1 | v1 | [2](https://github.com/carlosgarcia8/gkri/issues/2) |
| R03 | Mostrar los posts | Importante | Funcional | Fácil | v1 | v1 | [3](https://github.com/carlosgarcia8/gkri/issues/3) |
| R04 | Borrar un post | Importante | Funcional | Fácil | v1 | v1 | [4](https://github.com/carlosgarcia8/gkri/issues/4) |
| R05 | Crear un post | Importante | Funcional | Fácil | v1 | v1 | [5](https://github.com/carlosgarcia8/gkri/issues/5) |
| R06 | Actualizar un post | Importante | Funcional | Fácil | v1 | v1 | [6](https://github.com/carlosgarcia8/gkri/issues/6) |
| R07 | Re dimensionar imagen de un post | Importante | Funcional | Media | v1 | v1 | [7](https://github.com/carlosgarcia8/gkri/issues/7) |
| R08 | Re dimensinar gif de un post | Importante | Funcional | Alta | v2 | v2 | [31](https://github.com/carlosgarcia8/gkri/issues/31) |
| R09 | Cambiar configuración de la cuenta de un usuario | Importante | Funcional | Fácil | v1 | v1 | [8](https://github.com/carlosgarcia8/gkri/issues/8) |
| R10 | Cambiar configuración del perfil del usuario | Importante | Funcional | Fácil | v1 | v1 | [9](https://github.com/carlosgarcia8/gkri/issues/9) |
| R11 | Cambiar avatar del usuario | Importante | Funcional | Fácil | v1 | v1 | [10](https://github.com/carlosgarcia8/gkri/issues/10) |
| R12 | Re dimensionar imagen del avatar del usuario | Importante | Funcional | Fácil | v1 | v1 | [11](https://github.com/carlosgarcia8/gkri/issues/11) |
| R13 | Comentar un post | Importante | Funcional | Fácil | v2 | v2 | [32](https://github.com/carlosgarcia8/gkri/issues/32) |
| R14 | Mostrar comentarios de un post | Importante | Funcional | Fácil | v2 | v2 | [33](https://github.com/carlosgarcia8/gkri/issues/33) |
| R15 | Comentar otro comentario (reply) | Importante | Funcional | Alta | v2 | v2 | [34](https://github.com/carlosgarcia8/gkri/issues/34) |
| R16 | Borrar comentario siendo usuario | Importante | Funcional | Fácil | v2 | v2 | [35](https://github.com/carlosgarcia8/gkri/issues/35) |
| R17 | Moderación de posts | Importante | Funcional | Fácil | v2 | v1 | [36](https://github.com/carlosgarcia8/gkri/issues/36) |
| R18 | Votar positivo un post | Importante | Funcional | Fácil | v2 | v2 | [37](https://github.com/carlosgarcia8/gkri/issues/37) |
| R19 | Votar negativo un post | Importante | Funcional | Fácil | v2 | v2 | [38](https://github.com/carlosgarcia8/gkri/issues/38) |
| R20 | Votar positivo un comentario | Importante | Funcional | Fácil | v2 | v2 | [39](https://github.com/carlosgarcia8/gkri/issues/39) |
| R21 | Votar negativo un comentario | Importante | Funcional | Fácil | v2 | v2 | [40](https://github.com/carlosgarcia8/gkri/issues/40) |
| R22 | El usuario puede seguir a otros usuarios | Opcional | Funcional | Media | v3 | v3 | [70](https://github.com/carlosgarcia8/gkri/issues/70) |
| R23 | El usuario puede tener seguidores | Opcional | Funcional | Media | v3 | v3 | [71](https://github.com/carlosgarcia8/gkri/issues/71) |
| R24 | Notificación de comentario | Importante | Funcional | Media | v3 | v3 | [72](https://github.com/carlosgarcia8/gkri/issues/72) |
| R25 | Notificación de reply | Opcional | Funcional | Media | v3 | v3 | [73](https://github.com/carlosgarcia8/gkri/issues/73) |
| R26 | Notificación de post nuevo | Opcional | Funcional | Media | v3 | v3 | [74](https://github.com/carlosgarcia8/gkri/issues/74) |
| R27 | Notificación de seguidor nuevo | Opcional | Funcional | Media | v3 | v3 | [75](https://github.com/carlosgarcia8/gkri/issues/75) |
| R28 | Notificación de votos en tu post | Importante | Funcional | Media | v3 | v3 | [76](https://github.com/carlosgarcia8/gkri/issues/76) |
| R29 | Notificación de post aceptado | Importante | Funcional | Media | v3 | v3 | [77](https://github.com/carlosgarcia8/gkri/issues/77) |
| R30 | Logout de usuario | Importante | Funcional | Fácil | v1 | v1 | [12](https://github.com/carlosgarcia8/gkri/issues/12) |
| R31 | Recordar usuario | Importante | Funcional | Fácil | v1 | v1 | [13](https://github.com/carlosgarcia8/gkri/issues/13) |
| R32 | Ver todos los usuarios | Importante | Funcional | Fácil | v1 | v1 | [14](https://github.com/carlosgarcia8/gkri/issues/14) |
| R33 | Confirmar un usuario | Importante | Funcional | Fácil | v1 | v1 | [15](https://github.com/carlosgarcia8/gkri/issues/15) |
| R34 | Convertirse en un usuario | Importante | Funcional | Fácil | v1 | v1 | [16](https://github.com/carlosgarcia8/gkri/issues/16) |
| R35 | Bloquear usuario | Importante | Funcional | Fácil | v1 | v1 | [17](https://github.com/carlosgarcia8/gkri/issues/17) |
| R36 | Generar nueva contraseña | Importante | Funcional | Fácil | v1 | v1 | [18](https://github.com/carlosgarcia8/gkri/issues/18) |
| R37 | Crear nuevo usuario | Importante | Funcional | Fácil | v1 | v1 | [19](https://github.com/carlosgarcia8/gkri/issues/19) |
| R38 | Eliminar usuario | Importante | Funcional | Fácil | v1 | v1 | [20](https://github.com/carlosgarcia8/gkri/issues/20) |
| R39 | Actualizar usuario | Importante | Funcional | Fácil | v1 | v1 | [21](https://github.com/carlosgarcia8/gkri/issues/21) |
| R40 | Mandar email de confirmación | Importante | Funcional | Fácil | v1 | v1 | [22](https://github.com/carlosgarcia8/gkri/issues/22) |
| R41 | Volver a enviar mensaje de confirmación | Importante | Funcional | Fácil | v1 | v1 | [23](https://github.com/carlosgarcia8/gkri/issues/23) |
| R42 | Borrar usuarios no confirmados | Importante | Funcional | Fácil | v1 | v1 | [24](https://github.com/carlosgarcia8/gkri/issues/24) |
| R43 | Recuperar contraseña | Importante | Funcional | Fácil | v1 | v1 | [25](https://github.com/carlosgarcia8/gkri/issues/25) |
| R44 | Enviar mensaje privado a otro usuario | Opcional | Funcional | Fácil | v3 | v3 | [78](https://github.com/carlosgarcia8/gkri/issues/78) |
| R45 | Crear mensaje privado | Opcional | Funcional | Fácil | v3 | v3 | [79](https://github.com/carlosgarcia8/gkri/issues/79) |
| R46 | Eliminar mensaje privado | Opcional | Funcional | Fácil | v3 |  | [80](https://github.com/carlosgarcia8/gkri/issues/80) |
| R47 | Recibir mensaje privado de otro usuario | Opcional | Funcional | Fácil | v3 | v3 | [81](https://github.com/carlosgarcia8/gkri/issues/81) |
| R48 | Ver mensajes privados recibidos | Opcional | Funcional | Fácil | v3 | v3 | [82](https://github.com/carlosgarcia8/gkri/issues/82) |
| R49 | Ver mensajes privados enviados | Opcional | Funcional | Fácil | v3 | v3 | [83](https://github.com/carlosgarcia8/gkri/issues/83) |
| R50 | Notificación de mensaje privado recibido | Opcional | Funcional | Media | v3 | v3 | [84](https://github.com/carlosgarcia8/gkri/issues/84) |
| R51 | Generador de memes | Opcional | Funcional | Alta | v3 | v3 | [85](https://github.com/carlosgarcia8/gkri/issues/85) |
| R52 | Mostrar un post en concreto | Importante | Funcional | Fácil | v1 | v1 | [26](https://github.com/carlosgarcia8/gkri/issues/26) |
| R53 | Buscar posts por categoría | Importante | Funcional | Fácil | v1 | v1 | [27](https://github.com/carlosgarcia8/gkri/issues/27) |
| R54 | Buscar posts por título | Importante | Funcional | Fácil | v1 | v1 | [28](https://github.com/carlosgarcia8/gkri/issues/28) |
| R55 | Iniciar sesión por medio de google+ | Importante | Funcional | Fácil | v1 | v1 | [29](https://github.com/carlosgarcia8/gkri/issues/29) |
| R56 | Guardar las variables de sesión en la base de datos | Importante | Funcional | Fácil | v1 | v1 | [30](https://github.com/carlosgarcia8/gkri/issues/30) |
| R57 | Uso de Amazon S3 | Importante | Funcional | Alta | v2 | v1 | [41](https://github.com/carlosgarcia8/gkri/issues/41) |
| R58 | Pausar y reanudar los distintos posts | Importante | Funcional | Media | v2 | v2 | [42](https://github.com/carlosgarcia8/gkri/issues/42) |
| R59 | Plugin para el generador de memes | Opcional | Funcional | Alta | v3 | v3 | [86](https://github.com/carlosgarcia8/gkri/issues/86) |
