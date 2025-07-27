<?php

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\models\User;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'Online Learning Video Repository ',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            User::isGuest() ? (
            [ 'label' => 'Register', 'url' => ['/site/register']] ) : ( '' ),

            User::isGuest() ? (['label' => 'Login', 'url' => ['/site/login']]) : ( '' ),

            User::isGuest() ? (
                [ 'label' => 'Admin Login', 'url' => ['/site/admin-log-in']] ) : ( '' ),

            !User::isGuest() ? (
                [ 'label' => 'Add Video', 'url' => ['/video/add']] ) : ( '' ),

            !User::isGuest() ? (
                [ 'label' => 'My Saved Videos', 'url' => ['/favorite/my']] ) : ( '' ),

            // rigester login adminlogin contact about
            !User::isGuest() ? (
                [ 'label' => 'Modules', 'url' => ['/module/all']] ) : ( '' ),

            ['label' => 'Feedback', 'url' => ['/site/contact']],

            ['label' => 'About', 'url' => ['/site/about']],



            !User::isGuest() ? ('<li>'
                . Html::beginForm(['/site/logout'], 'post', ['class' => 'navbar-form'])
                . Html::submitButton(
                    'Logout (' . Yii::$app->user->identity->username . ')',
                    ['class' => 'btn btn-link']
                )
                . Html::endForm()
                . '</li>'
            ) : ('')



        ],
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?php
            foreach (Yii::$app->session->getAllFlashes() as $key => $message) {
                echo '<div class="alert alert-' . $key . ' fade in"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' . $message . '</div>';
            }
        ?>
        <?= $content ?>
    </div>
</div>

<footer class="">

</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
