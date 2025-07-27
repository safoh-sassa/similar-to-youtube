<?php
use app\models\User;
use yii\helpers\Html;
use yii\widgets\LinkPager;
use app\models\Modules;

$this->title = 'All Modules';
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= $this->title ?></h1>

<?php if( User::isAdmin() ): ?>
    <?= Html::a('Add New', ['module/add'], ['class' => 'btn btn-success']) ?>
    <div class="clearfix"></div>
    <br>
<?php endif; ?>

<div class="site-index " id="modules">
    <div class="row">
        <div class="col-lg-4 col-md-6 col-xs-7 col-sm-12">
            <ul class="list-group">
                <?php foreach ($modules as $module): ?>
                    <li class="list-group-item" id="module-id-<?= $module->id ?>">
                        <?= Html::a(Html::encode($module->module_name), ['video/module', 'id' => $module->id]) ?>
                        <?php if( User::isAdmin() ): ?> <?= Html::a('Delete', ['module/delete', 'id' => $module->id],
                            ['class' => 'btn btn-xs btn-danger pull-right']) ?>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>

    <?= LinkPager::widget(['pagination' => $pagination]) ?>
</div>




