Global Klingon Radian Imaginary
==================

**Proyecto Integrado de Desarrollo de aplicaciones web (DAW)** realizado en el año 2017.

Aplicación enfocada a la subida de imágenes que los usuarios quieran compartir
y a poder comentarlas entre ellos de manera global. Básicamente es una idea parecida a
[9gag](http://9gag.com). Los usuarios se registran e iniciando sesión pueden ya publicar sus
comúnmente llamados “memes” aunque hay de todo tipo, también se pueden subir
imágenes propias y graciosas de la vida cotidiana a la vez que gifs. Tiene su apartado de
comentarios con votos positivos/negativos tanto los posts como los comentarios, sus
replies y demás.


## Requisitos
------------
- php >= 7.0.0
- PostgreSQL >= 9.5
- composer

## Instalación

1. Instalar el *PostgreSQL* y crear una base de datos con nombre `gkri` y un usuario `gkri`, la contraseña debera estar como variable de entorno en la configuración del servidor (apache2 o nginx).

2. Instalar el *composer*.

```
git clone https://github.com/carlosgarcia8/gkri.git
cd gkri
composer install
```

3. Cambiar la distinta configuración:
    + Cuenta de amazon s3.
    + Cuenta de CloudConvert
    + Correo electrónico

> Recuerda que esta configuración debera de estar como variables de entorno para evitar que esten hard-codeadas.
