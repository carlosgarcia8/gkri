Dificultades encontradas y soluciones aplicadas
==================

#### Convertir de gif a mp4
- A la hora de querer cambiar el formato de `image/gif` a `video/mp4` me encontré con el problema de que era pasar de una imagen a un video. Por medio de comandos parecía que se podía lograr, pero con una serie de librerías instaladas, las cuales el servidor Heroku no tenia instaladas por defecto. Probé a usar un web service que no era el que se usa ahora, pero era muy enrevesado y lo deje. Probé de muchas maneras y no daba con la tecla, por un momento pensé en dejarlo como gif aunque pesara mucho y no pudiera pausarlo, solo detenerlo y reanudarlo. Fue entonces cuando encontré la aplicación CloudConvert y empecé a usarla. Aunque solo te deja 25 conversiones diarias, las hace muy fácil por medio de su propia librería y haciendo uso de su api y con peticiones usando `curl` le pido que me de cuantas conversiones me quedan y si no tengo mas, impido que se suban gifs.

____

#### Problemas con la extensión yii2/comments
- Uno de los problemas fue que los comentarios salían ordenados desde el más reciente al más antiguo, lo cual no tenía sentido. Sobre todo en el apartado 'replies' en el cual la conversación parecía ir al revés, pues los más nuevos iban arriba y los más antiguos se quedaban abajo. Me puse en contacto con el creador de la extensión y le comente el problema en la siguiente [issue](https://github.com/yii2mod/yii2-comments/issues/62). Al parecer por defecto el mysql que usaba él se lo ordenaba bien, en cambio en Postgresql me lo ordenaba al revés. La solución que me dio fue que añadió el orderBy en la consulta sql y ya lo hacía bien para todos.

- El siguiente problema fue que al añadir un comentario nuevo, los eventos que les hubiera añadido yo a, por ejemplo, votar positivo, negativo o responder, se perdían. Se perdían por que la extensión se traía todo el árbol de comentarios y los añadia por ajax, perdiendo así los eventos que les añadia yo. Me puse en contacto con él de nuevo por medio de la siguiente [issue](https://github.com/yii2mod/yii2-comments/issues/65). Le añadió a la extensión la posibilidad de ejecutar eventos javascript antes y después de crear los comentarios, borrarlos y demás y ya con esto pude hacerlo funcionar como quería.

____

#### Navbar de Bootstrap
- El widget del yii2 que saca el navbar de bootstrap traía por defecto el collapse, el cual para el menú que hacia yo para la aplicación salía bastante mal cuando hacia el responsive. La solución que hice fue deshabilitar el collapse y hacer mis propios media query para el menú, sin tener en cuenta bootstrap.

____

#### La extensión yii2/user no realizaba 'repetir contraseña' para ninguna de sus opciones
- Al parecer el creador de la extensión no veía como una opción que el usuario al registrarse o al cambiar la contraseña, le solicitara el 'repetir contraseña' pues lo veía una perdida de tiempo. Tuve que sobre escribir sus formularios y lógica para poder implementarlo.

____

#### Problema con correo Gmail
- Al intentar registrarse o enviar solicitud de recuperación de contraseña desde Heroku, el cual el servidor esta en Irlanda, gmail me bloqueaba la cuenta pues veía como un acceso malicioso que entrara desde allí. Al final tuve que pillarme otro servidor smtp y así tener un correo ajeno a google.

____

#### Opciones del plugin Generador de Memes no funcionaban
- Usando el plugin jquery-meme-generator me di cuenta de que aunque el creador decía que la opción ShowAdvancedSettings funcionaba y demás, no lo hacia. Al parecer la opción la tenia, pero no la comprobaba. Modifique el código fuente añadiendole la comprobación y arreglado. Hice un fork en github, hice el cambio y le solicite un pull request para que nadie tuviera este error. [enlace al fork con el cambio](https://github.com/carlosgarcia8/jquery-meme-generator/tree/patch-1)

____

#### Google Chrome cache
- Al subir cualquier imagen de avatar del usuario, chrome guarda en cache la anterior y da la sensación de que nunca se ha realizado tal subida de fichero. La solución que he hecho ha sido añadirle a la ruta un parámetro `t` con la fecha actual, así chrome se cree que es una petición distinta de fichero y siempre lo recarga. Ejemplo: `/uploads/posts/4.mp4?t=24-05-2017-09:09:15`
