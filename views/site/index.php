<?php
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\widgets\ListView;
use yii\bootstrap\ActiveForm;
use app\models\User;

$this->title = !$searchModel->search ? 'All videos' : 'Search result for "' . Html::encode($searchModel->search) . '"';
$this->params['breadcrumbs'][] = $this->title;
?>
    <h1><?= Html::encode($this->title) ?></h1>
<h3>
<?php
    if( !User::isGuest() && User::isAdmin() ) {
        echo 'Welcome,Admin.';
    }
    ?>
</h3>
    <div class="row">
        <div class="col-lg-5 col-md-6 col-sm-12 col-xs-12">
            <div class="panel panel-default">
                <?php $form = ActiveForm::begin([
                    'method' => 'get',
                    'fieldConfig' => [
                        'template' => "{input}",
                        'options' => [
                            'tag'=>'div'
                        ]
                    ]
                ]); ?>
                <div class="input-group">
                    <?= $form->field($searchModel, 'search')->label(false)->textInput(['placeholder' => "Search by Title, URL or Description."]) ?>
                    <span class="input-group-btn">
                        <?= Html::submitButton('Search', ['class' => 'btn btn-success']) ?>
                    </span>
                </div><!-- /input-group -->
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>

    <div class="row">
        <?php Pjax::begin();
            echo ListView::widget([
                'dataProvider' => $dataProvider,
                'options' => [
                    'tag' => 'div',
                    'class' => 'col-lg-5 col-md-6 col-sm-12 col-xs-12 all-videos-from-users',
                ],
                'layout' => "{items}\n{pager}",
                'itemView' => function($video, $key, $index, $widget) {
                    return $this->render('_list_item_video', ['video' => $video]);
                },
                'pager' => [
                    'firstPageLabel' => 'First',
                    'lastPageLabel' => 'Last',
                    'nextPageLabel' => 'Next',
                    'prevPageLabel' => 'Previous',
                    'maxButtonCount' => 3
                ]
            ]);
        Pjax::end(); ?>
    </div>
