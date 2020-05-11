<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\YiiAsset;
use yii\widgets\DetailView;
use core\entities\User;
use core\helpers\UserHelper;

/* @var $this yii\web\View */
/* @var $model User */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Пользователь ' . $this->title;
YiiAsset::register($this);
?>
<div class="nav-tabs-custom">
    <div class="tab-content">
        <p>
            <?= Html::a('Изменить', ['edit', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?php if (Yii::$app->user->can('admin', ['user' => $model])): ?>
                <?= Html::a('Смена пароля', ['change-password', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?php endif;?>
            <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>
        </p>
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                'username',
                'email:email',
                [
                    'label' => 'Роль',
                    'value' => implode(', ', ArrayHelper::getColumn(Yii::$app->authManager->getRolesByUser($model->id), 'description')),
                    'format' => 'raw',
                ],
                [
                    'attribute' => 'Статус',
                    'value' => function (User $model) {
                        return UserHelper::statusLabel($model->status);
                    },
                    'format' => 'raw',
                ],
                'created_at:datetime',
                'updated_at:datetime',
            ],
        ]) ?>
    </div>
</div>