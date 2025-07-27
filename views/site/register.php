<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\models\User;

$this->title = 'Register';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to register:</p>
    <div class="row">
        <div class="col-lg-6 col-xs-12">
            <?php $form = ActiveForm::begin([
                'id' => 'register-form'
            ]); ?>
                <?= $form->field($model, 'student_id')->label('Student ID')->textInput() ?>
                <?= $form->field($model, 'first_name')->textInput() ?>
                <?= $form->field($model, 'last_name')->textInput() ?>
                <?= $form->field($model, 'username')->textInput() ?>
                <?= $form->field($model, 'email')->textInput(['type' => 'email']) ?>
                <?= $form->field($model, 'password')->passwordInput() ?>
                <?= Html::submitButton('Register', ['class' => 'btn btn-primary', 'name' => 'register-button']) ?>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
