<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\models\Module;

$this->title = 'Edit Video';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>Please fill out the following fields to upload a video:</p>
    <div class="row">
        <div class="col-lg-6 col-xs-12">

            <?php $form = ActiveForm::begin([
                'id' => 'add-video'

            ]); ?>
            <?= $form->field($model, 'title')->textInput(['value' => $video->title ]) ?>
            <?= $form->field($model, 'url')->textInput(['value' => $video->url ]) ?>
            <?= $form->field($model, 'description')->textInput(['value' => $video->description ]) ?>
            <?= $form->field($model, 'module_id')->label('Module')->dropDownList(
                Module::getCategories(),
                ['options' => [
                    $video->module_id => ['selected' => true]
                ]
            ]) ?>
            <?= Html::submitButton('Save', ['class' => 'btn btn-primary', 'name' => 'register-button']) ?>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
