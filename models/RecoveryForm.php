<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace app\models;

use dektrium\user\Finder;
use dektrium\user\Mailer;

use dektrium\user\models\Token;
use dektrium\user\models\RecoveryForm as BaseRecoveryForm;

/**
 * Modelo formulario para la recuperación de la contraseña.
 */
class RecoveryForm extends BaseRecoveryForm
{
    /**
     * Escenario para cuando solicitas la recuperación
     * @var string
     */
    const SCENARIO_REQUEST = 'request';

    /**
     * Escenario para cuando reinicias la contraseña
     * @var string
     */
    const SCENARIO_RESET = 'reset';

    /**
     * @var string
     */
    public $email;

    /**
     * @var string
     */
    public $password;

    /**
     * @var string
     */
    public $repeat_password;

    /**
     * @var Mailer
     */
    protected $mailer;

    /**
     * @var Finder
     */
    protected $finder;

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'email'    => \Yii::t('user', 'Email'),
            'password' => \Yii::t('user', 'New password'),
            'repeat_password' => \Yii::t('user', 'Repeat password'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            self::SCENARIO_REQUEST => ['email'],
            self::SCENARIO_RESET => ['password', 'repeat_password'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            'emailTrim' => ['email', 'filter', 'filter' => 'trim'],
            'emailRequired' => ['email', 'required'],
            'emailPattern' => ['email', 'email'],
            'passwordRequired' => [['password', 'repeat_password'], 'required'],
            'passwordLength' => ['password', 'string', 'max' => 72, 'min' => 6],
            'passwordRepeat' => ['repeat_password', 'compare', 'compareAttribute' => 'password'],
        ];
    }

    /**
     * Envia el mensaje de recuperación.
     *
     * @return bool
     */
    public function sendRecoveryMessage()
    {
        if (!$this->validate()) {
            return false;
        }

        $user = $this->finder->findUserByEmail($this->email);

        if ($user instanceof User) {
            /** @var Token $token */
            $token = \Yii::createObject([
                'class' => Token::className(),
                'user_id' => $user->id,
                'type' => Token::TYPE_RECOVERY,
            ]);

            if (!$token->save(false)) {
                return false;
            }

            if (!$this->mailer->sendRecoveryMessage($user, $token)) {
                return false;
            }
        }

        \Yii::$app->session->setFlash(
            'info',
            \Yii::t('user', 'An email has been sent with instructions for resetting your password')
        );

        return true;
    }

    /**
     * Resetea la contraseña del usuario.
     *
     * @param Token $token
     *
     * @return bool
     */
    public function resetPassword(Token $token)
    {
        if (!$this->validate() || $token->user === null) {
            return false;
        }

        if ($token->user->resetPassword($this->password)) {
            \Yii::$app->session->setFlash('success', \Yii::t('user', 'Your password has been changed successfully.'));
            $token->delete();
        } else {
            \Yii::$app->session->setFlash(
                'danger',
                \Yii::t('user', 'An error occurred and your password has not been changed. Please try again later.')
            );
        }

        return true;
    }

    /**
     * @inheritdoc
     */
    public function formName()
    {
        return 'recovery-form';
    }
}
