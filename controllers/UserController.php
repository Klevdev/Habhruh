<?php

namespace app\controllers;

use Yii;
use app\models\User;
use \yii\web\Controller;

// TODO: Реализовать хэширование паролей
// TODO: Привести этот контроллер в порядок

class UserController extends Controller {
    public function actionSignup() {
        $this->view->title = 'Регистрация';
        $user = new User();
        if ($user->load(Yii::$app->request->post())) {
            if ($user->validate()) {
                if (!User::userExsists($user->email)) {
                    $password = Yii::$app->request->post('User')['password'];
//                    $user->password = User::encryptPassword($password);
                    if ($user->save()) {
                        $user = User::getUser('email', $user->email, ['id', 'name', 'avatar_url']);

                        $session = Yii::$app->session;
                        $session->set('user', [
                            'id' => $user['id'],
                            'name' => $user['name'],
                            'avatar' => $user['avatar_url']
                        ]);

                        return $this->redirect(['/']);
                    }
                } else {
                    Yii::$app->session->setFlash('error', 'Адрес электронной почты занят');
                }
            } else {
                Yii::$app->session->setFlash('error', 'При обработке данных произошла ошибка');
            }
        }

        return $this->render('signup', compact('user', 'find'));
    }

    public function actionLogin() {
        $this->view->title = 'Вход';
        $user = new User();
        if ($user->load(Yii::$app->request->post())) {
            if ($user->validate(['email', 'password'])) {
                $email = Yii::$app->request->post('User')['email'];
                $password = Yii::$app->request->post('User')['password'];
                //            $password = User::encryptPassword($password);
                $find = User::userExsists($email, $password);
                if ($find) {
                    $user = User::getUser('email', $user->email, ['id', 'name', 'avatar_url']);
                    $session = Yii::$app->session;
                    $session->set('user', [
                        'id' => $user['id'],
                        'name' => $user['name'],
                        'avatar' => $user['avatar_url']
                    ]);
                    return $this->redirect(['/']);
                } else {
                    Yii::$app->session->setFlash('error', 'Ошибка - неправильный логин или пароль');
                }
            } else {
                Yii::$app->session->setFlash('error', 'При обработке данных произошла ошибка');
            }
        }

        return $this->render('login', compact('user'));
    }

    public function actionLogout() {
        Yii::$app->session->destroy();
        $this->redirect(['/']);
    }
}