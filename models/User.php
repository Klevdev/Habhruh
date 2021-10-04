<?php

namespace app\models;

use yii\db\ActiveRecord;

class User extends ActiveRecord {
    public $password_repeat;

    public function attributeLabels() {
        return [
            'name' => 'Имя пользователя',
            'email' => 'E-mail',
            'password' => 'Пароль',
            'password_repeat' => 'Повторите пароль',
        ];
    }
    public function rules() {
        return [
            [['name', 'email', 'password', 'password_repeat'], 'required', 'message' => 'Поле необходимо заполнить'],
            [['name', 'email'], 'trim',],
            [['email'], 'email'],
            [['name'], 'string', 'length' => [3, 20]],
            [['email'], 'string', 'max' => 30],
            [['password'], 'string', 'length' => [8, 30]],
            [['password_repeat'], 'compare', 'compareAttribute'=>'password', 'message' => 'Пароли должны совпадать'],
        ];
    }

    public static function userExsists($email, $password=null) {
        $find = User::find()
            ->select('id')
            ->asArray()
            ->where("email = '$email'" . ($password !== null ? "AND password = '$password'": ''))
            ->all();

        return empty($find) ? false : true;
    }

    public static function getUser($searchKey, $searchValue, Array $getValues) {
        $find = User::find()
            ->select($getValues)
            ->asArray()
            ->where(['=', $searchKey, $searchValue])
            ->all()[0];

        return empty($find) ? null : $find;
    }

// TODO: Реализовать хэширование паролей
//    public static function encryptPassword($password) {
//        return md5(md5('БожеЦаряХрани'.$password).'БожеЦаряХрани');
//    }


}
