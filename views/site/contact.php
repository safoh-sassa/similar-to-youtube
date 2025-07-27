<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Feedback';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to send a message to the admin:</p>

    <div class="row">
        <div class="col-lg-6 col-md-7 col-xs-12">
            <?php $form = ActiveForm::begin(); ?>

                <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>
                <?= $form->field($model, 'email')->textInput(['type' => 'email']) ?>
                <?= $form->field($model, 'subject')->textInput() ?>
                <?= $form->field($model, 'message')->textArea(['rows' => 5]) ?>

                <div class="form-group">
                    <div class="col-lg-offset-1 col-lg-11">
                        <?= Html::submitButton('Send', ['class' => 'btn btn-primary', 'name' => 'feedback-button']) ?>
                    </div>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
