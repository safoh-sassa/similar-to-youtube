<?php
use yii\helpers\Html;
use app\models\Video;
use app\models\User;
use yii\helpers\Url;
?>

<div class="panel panel-default" id="video-id-<?= $video->id ?>">
    <div class="panel-heading">Title : <?= Html::a(Html::encode($video->title), ['video/view', 'id' => $video->id]) ?></div>
    <div class="panel-body">
        <?= Video::embedVideo($video->url) ?>

        <div class="video-description">
            <p>Description: <?= Html::encode($video->description) ?></p>
        </div>
    </div>
    <div class="panel-footer">
        <ul class="list-inline">
            <li>Module: <?= Html::encode($video->module->module_name) ?></li><br>
            <li>Added by <?= Html::encode($video->user->first_name) ?></li>

            <?php if( !User::isGuest() ): ?>
                <?php if( !Video::isFavorited($video->id) ) :?>
                    <li class="pull-right"><?= Html::a('Save', ['favorite/add', 'id' => $video->id, 'back_url' => Yii::$app->request->absoluteUrl], ['class' => 'btn btn-xs btn-success']) ?></li>
                <?php else: ?>
                    <li class="pull-right"><?= Html::a('Unsave', ['favorite/delete', 'id' => $video->id, 'back_url' => Yii::$app->request->absoluteUrl], ['class' => 'btn btn-xs btn-danger']) ?></li>
                <?php endif; ?>
            <?php endif; ?>
        </ul>
    </div>

</div>