<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\Url;

AppAsset::register($this);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<header>
    <div class="logo">Habruh</div>
    <nav>
        <?= Html::a('Главная', Url::to(['/'])) ?>
        <?= Html::a('Статьи', Url::to(['/posts/'])) ?>
        <?= Html::a('Избранное', Url::to(['/user/favorites'])) ?>
    </nav>
    <div id="user-panel">
        <?php if (Yii::$app->session->has('user')): ?>
            <span><?= Yii::$app->session->get('user')['name'] ?></span>
            <?= Html::a('Выйти', Url::to('/logout')) ?>
        <? else: ?>
            <?= Html::a('Войти', Url::to('/login')) ?>
            <?= Html::a('Зарегистрироваться', Url::to('/signup')) ?>
        <? endif; ?>
    </div>
</header>

<main>
    <?= $content ?>
</main>

<footer>
    <p>&copy; Alexander Klevakin <?= date('Y') ?></p>
    <p></p>
    <p><?= Yii::powered() ?></p>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
