<?php
use yii\helpers\Html;
use app\models\Video;
use app\models\User;
use app\models\Comment;
use yii\bootstrap\ActiveForm;
use yii\widgets\LinkPager;
?>

<div class="row">
    <div class="col-lg-8 col-lg-offset-2 col-md-8 col-md-offset-2 col-xs-12">
        <div class="panel panel-default" id="video-id-<?= $video->id ?>">
            <div class="panel-heading">Title: <?= Html::encode($video->title) ?></div>
            <div class="panel-body">
                <?= Video::embedVideo($video->url) ?>

                <div class="video-description">
                    <p>Description: <?= Html::encode($video->description) ?></p>
                </div>

                <div class="metadata">
                    <ul class="list-inline">
                        <li><span class="glyphicon glyphicon-user"></span> <?= Video::getAuthor($video->id) ?></li>
                        <li><span class="glyphicon glyphicon-eye-open"></span> <?= Video::getViewsCount($video->id) ?></li>
                        <li> <?php
                            if( !User::isGuest() ):
                                echo '<li>' . Html::a('<span class="glyphicon glyphicon-thumbs-up"></span> ' . Html::encode('Like (' . Video::getLikesNumber($video->id) . ')'), ['video/like', 'id' => $video->id], ['class' => 'btn btn-success']) . '</li>';

                                echo '<li>' . Html::a('<span class="glyphicon glyphicon-thumbs-down"></span> ' . Html::encode('Dislike (' . Video::getDislikesNumber($video->id) . ')'), ['video/dislike', 'id' => $video->id], ['class' => 'btn btn-danger']) . '</li>';
                            else:
                                echo '<li>' . Html::a('<span class="glyphicon glyphicon-thumbs-up"></span> ' . Html::encode('Like (' . Video::getLikesNumber($video->id) . ')'), '#', ['class' => 'btn btn-success', 'onclick' => 'alert("Please log in to like this video."); return false;']) . '</li>';

                                echo '<li>' . Html::a('<span class="glyphicon glyphicon-thumbs-down"></span> ' . Html::encode('Dislike (' . Video::getDislikesNumber($video->id) . ')'), '#', ['class' => 'btn btn-danger', 'onclick' => 'alert("Please log in to dislike this video."); return false;']) . '</li>';
                            endif; ?>
                        </li>
                    </ul>

                </div>
            </div>

            <hr>

            <div class="panel-body">
                <?= Html::a('Share it', '#', ['class' => 'btn btn-success', 'onclick' => '
                var el = document.getElementById("share-input");
                if( el.style.display == "none" )
                    el.style.display = "block";
                else
                    el.style.display = "none";
                return false;
                ']) ?>

                <div id="share-input" style="display: none;">
                    <br/><?= Html::input('text', 'videoUrl', Yii::$app->request->absoluteUrl, ['class' => 'form-control', 'onclick' => 'return this.select();']) ?>
                </div>
                <div class="clearfix"></div><br/>
                <ul class="list-inline">
                    <?php
                    if( !User::isGuest() && User::isAdmin() || Video::isMy($video->id) ): ?>
                        <li>
                            <?= Html::a('<span class="glyphicon glyphicon-pencil"></span> ' . Html::encode('Edit'), ['video/edit', 'id' => $video->id], ['class' => 'btn btn-warning']) ?>
                        </li>
                        <li>
                            <?= Html::a('<span class="glyphicon glyphicon-trash"></span> ' . Html::encode('Delete'), ['video/delete', 'id' => $video->id], ['class' => 'btn btn-warning']) ?>
                        </li>
                    <?php endif;?>


                </ul>
            </div>

            <div class="panel-body">
                <h3>All Comments</h3>

                <?php $form = ActiveForm::begin([
                    'id' => 'comment-form',
                    'options' => [
                        'onsubmit' => User::isGuest() ? 'alert("Please log in to add a comment."); return false;' : ''
                    ],
                ]); ?>
                <?= $form->field($model, 'comment')->textArea(['rows' => 3]) ?>
                <div class="form-group">
                    <?= Html::submitButton('Comment', ['class' => 'btn btn-primary', 'name' => 'comment-button']) ?>
                </div>
                <?php ActiveForm::end(); ?>

                <div class="all-comments">
                    <?php if( Video::hasComments($video->id) ): ?>

                        <?php foreach($comments as $comment): ?>
                            <div class="panel panel-default" id="video-row-<?= $video->id ?>">
                                <div class="panel-body">
                                    <?= Html::encode($comment->comment) ?>
                                </div>
                                <div class="panel-footer">
                                    <ul class="list-inline clearfix">
                                        <li class="pull-left">Added by <?= Comment::getUserFullName($comment->id) ?></li>
                                        <li class="pull-right"><?= date('d M y \a\t H:i', $comment->date_sent) ?></li>
                                    </ul>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        <?php endforeach; ?>

                        <?= LinkPager::widget(['pagination' => $commentsPagination]) ?>
                    <?php else: ?>
                        <p>This video does not have any comments. You can add the first one below.</p>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>
</div>