<?php

declare(strict_types=1);

namespace app\controllers\auth;

use app\core\interfaces\MailerInterface;
use app\forms\auth\ResetPasswordForm;
use app\forms\auth\SetPasswordForm;
use app\models\auth\User;
use manchenkov\yii\http\Controller;
use yii\base\Exception;
use yii\web\Response;

class PasswordController extends Controller
{
    /**
     * Request a reset password link by user email
     *
     * @param MailerInterface $mailer
     *
     * @return string
     */
    public function actionResetPassword(MailerInterface $mailer): string
    {
        $form = new ResetPasswordForm($mailer);

        if ($form->load(request()->post())) {
            if ($form->handle()) {
                $context = [
                    'icon' => 'email',
                    'title' => t('ui', 'title.great'),
                    'message' => t('ui', 'label.email-password-sent'),
                ];

                return view('@views/site/notification', $context);
            }
        }

        return view('reset-password', compact('form'));
    }

    /**
     * Set new password for a user
     *
     * @param string $token
     *
     * @return string|Response
     * @throws Exception
     */
    public function actionSetPassword(string $token)
    {
        $user = User::findIdentityByAccessToken($token);

        if ($user) {
            $form = new SetPasswordForm();

            if ($form->load(request()->post())) {
                if ($form->handle($user)) {
                    return view(
                        '@views/site/notification',
                        [
                            'icon' => 'done',
                            'title' => t('ui', 'title.great'),
                            'message' => t('ui', 'label.email-password-changed'),
                        ]
                    );
                }
            }

            return view('set-password', compact('form', 'token'));
        }

        return $this->goHome();
    }
}