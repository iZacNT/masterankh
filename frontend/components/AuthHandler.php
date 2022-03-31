<?php
namespace frontend\components;

use frontend\models\SocialAuth;
use frontend\models\User;
use Yii;
use yii\authclient\ClientInterface;
use yii\helpers\ArrayHelper;

/**
 * AuthHandler handles successful authentication via Yii auth component
 */
class AuthHandler
{
    /**
     * @var ClientInterface
     */
    private $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function handle()
    {
        $attributes = $this->client->getUserAttributes();
        $email = ArrayHelper::getValue($attributes, 'email');
        $id = ArrayHelper::getValue($attributes, 'id');
        $name = ArrayHelper::getValue($attributes, 'name');
        /* @var SocialAuth $auth */
        $auth = SocialAuth::find()->where([
            'source' => $this->client->getId(),
            'source_id' => $id,
        ])->one();
        if (Yii::$app->user->isGuest) {
            if ($auth) { // login
                /* @var User $user */
                $user = $auth->user;
                Yii::$app->user->login($user, 3600 * 24 * 7);
                $user->ip_last_login = Yii::$app->request->userIP;
                $user->save(true, ['ip_last_login']);
            } else { // signup
                if ($email !== null && User::find()->where(['email' => $email])->exists()) {
                    $user = User::findOne(['email' => $email]);
                    $transaction = User::getDb()->beginTransaction();
                    $auth = new SocialAuth([
                        'user_id' => $user->id,
                        'source' => $this->client->getId(),
                        'source_id' => (string)$id,
                    ]);
                    if ($auth->save()) {
                        $transaction->commit();
                        Yii::$app->user->login($user, 3600 * 24 * 7);
                        $user->ip_last_login = Yii::$app->request->userIP;
                        $user->save(true, ['ip_last_login']);
                    } else {
                        Yii::$app->getSession()->setFlash('error', [
                            Yii::t('app', 'Unable to save {client} account: {errors}', [
                                'client' => $this->client->getTitle(),
                                'errors' => json_encode($auth->getErrors()),
                            ]),
                        ]);
                    }

                } else {
                    $password = Yii::$app->security->generatePasswordHash($email);
                    $user = new User([
                        'email' => $email,
                        'second_email' => $email,
                        'name' => $name,
                        'surname' => '',
                        'password' => $password,
                        'send_email_active' => 0,
                        'status' => 1,
                    ]);

                    $transaction = User::getDb()->beginTransaction();
                    if ($user->save()) {
                        $auth = new SocialAuth([
                            'user_id' => $user->id,
                            'source' => $this->client->getId(),
                            'source_id' => (string)$id,
                        ]);
                        if ($auth->save()) {
                            $transaction->commit();
                            Yii::$app->user->login($user, 3600 * 24 * 7);
                            $user->ip_last_login = Yii::$app->request->userIP;
                            $user->save(true, ['ip_last_login']);
                        } else {
                            Yii::$app->getSession()->setFlash('error', [
                                Yii::t('app', 'Unable to save {client} account: {errors}', [
                                    'client' => $this->client->getTitle(),
                                    'errors' => json_encode($auth->getErrors()),
                                ]),
                            ]);
                        }
                    } else {
                        Yii::$app->getSession()->setFlash('error', [
                            Yii::t('app', 'Unable to save user: {errors}', [
                                'client' => $this->client->getTitle(),
                                'errors' => json_encode($user->getErrors()),
                            ]),
                        ]);
                    }
                }
            }
        } else { // user already logged in
            if (!$auth) { // add auth provider
                $auth = new SocialAuth([
                    'user_id' => Yii::$app->user->id,
                    'source' => $this->client->getId(),
                    'source_id' => (string)$attributes['id'],
                ]);
                if ($auth->save()) {
                    /** @var User $user */
                    $user = $auth->user;
                    Yii::$app->getSession()->setFlash('success', [
                        Yii::t('app', 'Linked {client} account.', [
                            'client' => $this->client->getTitle()
                        ]),
                    ]);
                } else {
                    Yii::$app->getSession()->setFlash('error', [
                        Yii::t('app', 'Unable to link {client} account: {errors}', [
                            'client' => $this->client->getTitle(),
                            'errors' => json_encode($auth->getErrors()),
                        ]),
                    ]);
                }
            } else { // there's existing auth
                Yii::$app->getSession()->setFlash('error', [
                    Yii::t('app',
                        'Unable to link {client} account. There is another user using it.',
                        ['client' => $this->client->getTitle()]),
                ]);
            }
        }
    }
}
