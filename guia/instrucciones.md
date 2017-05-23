Instrucciones de instalación y despliegue
==================
### En local
#### Requisitos
- php >= 7.0.0
- PostgreSQL >= 9.5
- composer
- Cuenta en AWS S3
- Cuenta en CloudConvert
- Registrar una aplicación en Google+ API para poder iniciar sesión con la cuenta de google+
- Correo electrónico
- Tener apache2 (u otro servidor) bien configurado

#### Instalación

1. Tener el apache2 (u otro servidor) configurado con un nombre de dominio creado (ej: gkri.local) y enlazado a `gkri/web/`.


2. Instalar el *composer*.

3. Seguir estos comandos.
```
git clone https://github.com/carlosgarcia8/gkri.git
cd gkri
composer install
composer run-script post-create-project-cmd
cd web
chmod -R 777 uploads
```

4. Instalar el *PostgreSQL* y ejecutar los siguientes comandos desde la raiz del proyecto.
```
cd db
./init.sh
./migraciones.sh
./create.sh
```
Se habrá creado una base de datos llamada `gkri` con un usuario `gkri` y contraseña `gkri`.

5. Cambiar la distinta configuración:
    + Admin.
        - Cambiar el nombre de usuario de admins en `/config/web.php` para que concuerde con tu nombre de usuario.
    + Cuenta de amazon s3.
        - En `/config/web.php` cambiar el bucket y demas propiedades de la configuración que se tenga en AWS S3.
        - AWS_KEY: variable de entorno para la clave de AWS.
        - AWS_SECRET: variable de entorno para el secret de AWS.
    + Cuenta de CloudConvert
        - CC_KEY: variable de entorno para la clave de CloudConvert.
    + Correo electrónico
        - Cambiar el correo electrónico en `/config/web.php`.
        - SMTP_PASS: variable de entorno para la contraseña del correo electrónico.
    + Google+ api
        - GOOGLE_ID: variable de entorno para el id de la api google+.
        - GOOGLE_PASS: variable de entorno para la key de la api google+

> Recuerda que esta configuración deberá de estar como variables de entorno para evitar que esten hard-codeadas (Solo la que se especifique como tal).

### En la nube

#### Despliegue en Heroku

1. Tener cuenta en heroku y crear una aplicación. Instalar el comando heroku para trabajar por linea de comandos o bien hacerlo desde la página web.
2. Establecer las mismas variables de entorno que en local añadiendole una más (`YII_ENV=prod`).
3. Añadir el addon heroku-postgresql. Realizar un dump de la base de datos local o si se quiere se puede usar el dump.sql que viene en `db/`(conociendo que ya tiene un usuario creado).
4. Si se quiere añadir la funcionalidad de que cada 24 horas se borren los usuarios no confirmados, añadir el heroku-scheduler (se necesita añadir tarjeta de crédito a heroku) y decirle que ejecute el comando `./yii limpiar`.
5. Ejecutar los siguientes comandos:
```
cd gkri
heroku login
heroku git:remote -a nombre_aplicacion_heroku
git push heroku master
```
