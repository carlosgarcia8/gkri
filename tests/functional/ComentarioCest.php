<?php
use app\models\User;

/**
 * Clase encargada de las pruebas relacionadas con los comentarios
 * @param  FunctionalTester $I
 */
class ComentarioCest
{
    /**
     * Método previo a cada prueba, basicamente inicia sesión y se va a la página de un post en concreto
     * @param  FunctionalTester $I
     */
    public function _before(FunctionalTester $I)
    {
        $I->amLoggedInAs(User::findOne(1));
        $I->amOnPage(['/posts/5']);
    }

    /**
     * Comprobamos que se ha podido abrir la página del post en concreto
     * @param  FunctionalTester $I
     */
    public function abrirLaPaginaDeUnPost(FunctionalTester $I)
    {
        $I->see('¿Por que será? ', 'h2');
    }

    /**
     * Creamos un comentario vacio y comprobamos que da error
     * @param  FunctionalTester $I
     */
    public function crearComentarioVacio(FunctionalTester $I)
    {
        $I->submitForm('#comment-form', []);
        $I->expectTo('see validations errors');
        $I->see('El comentario no puede estar vacio.');
    }

    /**
     * Creamos un comentario relleno
     * @param  FunctionalTester $I
     */
    public function crearComentarioRelleno(FunctionalTester $I)
    {
        $I->submitForm('#comment-form', [
            'CommentModel[content]' => 'Jaja'
        ]);
    }

    /**
     * Comprobamos que el comentario se crea correctamente
     * @param  FunctionalTester $I
     */
    public function comprobarComentarioCreado(FunctionalTester $I)
    {
        $I->see('Jaja', 'div');
        $I->seeRecord('app\models\CommentModel', ['id' => 7]);
    }

    /**
     * Comprobamos que la notificación de comentarios nuevos se ha creado para el autor del post
     * @param  FunctionalTester $I
     */
    public function comprobarNotificacionCreada(FunctionalTester $I)
    {
        $I->seeRecord('app\models\Notificacion', ['id' => 51, 'type' => 2, 'user_id' => 4, 'post_id' => 5]);
    }

    /**
     * Borramos el comentario y comprobamos que no existe
     * @param  FunctionalTester $I
     */
    public function borrarComentarioYComprobar(FunctionalTester $I)
    {
        $I->sendAjaxPostRequest('/comment/default/delete?id=7', ['id' => 7]);
        $I->seeResponseCodeIs(200);
        $I->dontSeeRecord('app\models\CommentModel', ['id' => 7]);
    }

    /**
     * Comprobamos que la notificación ha sido borrada
     * @param  FunctionalTester $I
     */
    public function comprobarNotificacionBorrada(FunctionalTester $I)
    {
        $I->dontSeeRecord('app\models\Notificacion', ['id' => 51, 'type' => 2, 'user_id' => 4, 'post_id' => 5]);
    }
}
