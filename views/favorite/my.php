<?php

use app\models\Video;
use yii\helpers\Html;
use yii\widgets\LinkPager;
/* @var $this yii\web\View */

$this->title = 'My Favorite Videos';
$this->params['breadcrumbs'][] = $this->title;
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
                        <p><?= Html::encode($video->module->module_name) ?></p>
                    </div>
                </div>
                <div class="panel-footer">
                    <ul class="list-inline">
                        <?php if( !Video::isFavorited($video->id) ) :?>
                            <li><?= Html::a('Save', ['favorite/add', 'id' => $video->id], ['class' => 'btn btn-xs btn-success']) ?></li>
                        <?php else: ?>
                            <li><?= Html::a('Unsave', ['favorite/delete', 'id' => $video->id], ['class' => 'btn btn-xs btn-danger']) ?></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        <?php endforeach; ?>


        <?= LinkPager::widget(['pagination' => $pagination]) ?>
    <?php else: ?>
        <p>There are no favorite videos yet.</p>
    <?php endif; ?>
</div>

