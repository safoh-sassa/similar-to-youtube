<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Add Module';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>Please fill out the following fields to add new model:</p>
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'module_name')->textInput() ?>
    <?= Html::submitButton('Add', ['class' => 'btn btn-primary', 'name' => 'module-add-button']) ?>
    <?php ActiveForm::end(); ?>
</div>
