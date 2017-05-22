<?php
use app\models\User;

/**
 * Clase para realizar las pruebas que conllevan los follows
 */
class FollowCest
{
    /**
     * Método previo a cada prueba, basicamente inicia sesión y se va a la página de otro usuario
     * @param  FunctionalTester $I
     */
    public function _before(FunctionalTester $I)
    {
        $I->amLoggedInAs(User::findOne(1));
        $I->amOnPage(['u/milalangley']);
    }

    /**
     * Comprobamos que se ha podido abrir el perfil de otro usuario
     * @param  FunctionalTester $I
     */
    public function abrirPerfilDeOtroUsuario(FunctionalTester $I)
    {
        $I->see('Mila Langley', 'h4');
    }

    /**
     * Ya estamos siguiendo a dicho usuario por lo tanto le vamos a dejar de seguir
     * @param  FunctionalTester $I
     */
    public function dejarDeSeguir(FunctionalTester $I)
    {
        $I->seeRecord('app\models\Follow', ['user_id' => 1, 'follow_id' => 4]);
        $I->sendAjaxGetRequest('/follows/unfollow', ['follow_id' => 4]);
        $I->seeResponseCodeIs(200);
    }

    /**
     * Comprobar que le hemos dejado de eguir
     * @param  FunctionalTester $I
     */
    public function comprobarNoSiguiendo(FunctionalTester $I)
    {
        $I->dontSeeRecord('app\models\Follow', ['user_id' => 1, 'follow_id' => 4]);
    }

    /**
     * Comenzar a seguir a dicho usuario
     * @param  FunctionalTester $I
     */
    public function seguirUsuario(FunctionalTester $I)
    {
        $I->dontSeeRecord('app\models\Follow', ['user_id' => 1, 'follow_id' => 4]);
        $I->sendAjaxGetRequest('/follows/follow', ['follow_id' => 4]);
        $I->seeResponseCodeIs(200);
    }

    /**
    * Comprobamos que estamos siguiendo a dicho usuario
    * @param  FunctionalTester $I
    */
    public function comprobarSiguiendo(FunctionalTester $I)
    {
        $I->seeRecord('app\models\Follow', ['user_id' => 1, 'follow_id' => 4]);
    }

    /**
     * Comprobamos que se ha creado la notificación de nuevo seguidor
     * @param  FunctionalTester $I
     */
    public function comprobarNotificacionCreada(FunctionalTester $I)
    {
        $I->seeRecord('app\models\Notificacion', ['id' => 52, 'type' => 3, 'user_id' => 4, 'user_related_id' => 1]);
    }
}
