<?php
/* @var $this \yii\web\View */
/* @var $user \app\models\User */

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

$this->registerCssFile('@web/css/form.css');

?>
<div class="container">
    <h1>Вход</h1>

    <? if(Yii::$app->session->hasFlash('error')): ?>
        <span class="error"><?= Yii::$app->session->getFlash('error') ?></span>
    <? endif; ?>

    <?php $form = ActiveForm::begin([
            'method' => 'POST',
            'fieldConfig' => [
                    'template' => "{label}{hint}<span class='error'>{error}</span>{input}",
                ]
    ])
    ?>
        <?= $form->field($user, 'email')->input('email') ?>
        <?= $form->field($user, 'password')->passwordInput() ?>

        <?= Html::submitButton('Отправить') ?>
    <? $form = ActiveForm::end() ?>
</div>