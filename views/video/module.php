<?php
use app\models\User;
use app\models\Video;
use yii\helpers\Html;
use yii\widgets\LinkPager;

$this->title = 'All videos in "' . Html::encode($module->module_name) . '" module.';
?>
<h1><?= $this->title ?></h1>
<div class="site-index" id="div-video">
    <?php if( $videos ): ?>
        <?php foreach ($videos as $video): ?>
            <div class="panel panel-default" id="video-id-<?= $video->id ?>">
                <div class="panel-heading"><?= Html::a(Html::encode($video->title), ['video/view', 'id' => $video->id]) ?></div>
                <div class="panel-body">
                    <?= Video::embedVideo($video->url) ?>
                    <div class="video-description">
                        <p><?= Html::encode($video->description) ?></p>
                    </div>
                </div>
                <div class="panel-footer">
                    <ul class="list-inline">
                        <li>Added by <?= Html::encode($video->user->first_name) ?></li>
                        <li>Module :<?= Html::encode($video->module->module_name) ?></li>
                        <li>
                        <?php if( !User::isGuest() ): ?>
                            <?php if( !Video::isFavorited($video->id) ) :?>

                                <li><?= Html::a('Save', ['favorite/add', 'id' => $video->id, 'back_url' => Yii::$app->request->absoluteUrl], ['class' => 'btn btn-xs btn-success']) ?></li>
                            <?php else: ?>
                                <li><?= Html::a('Unsave', ['favorite/delete', 'id' => $video->id, 'back_url' => Yii::$app->request->absoluteUrl], ['class' => 'btn btn-xs btn-danger']) ?></li>
                            <?php endif; ?>
                        <?php endif; ?>
                        </li>
                    </ul>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>There is no video related to this module.</p>
    <?php endif; ?>
    <?= LinkPager::widget(['pagination' => $pagination]) ?>
</div>
