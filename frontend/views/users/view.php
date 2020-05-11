<?php

use frontend\widgets\ModerationButtons;
use yii\helpers\ArrayHelper;
use yii\web\YiiAsset;
use yii\widgets\DetailView;
use core\entities\User;
use core\helpers\UserHelper;

/* @var $this yii\web\View */
/* @var $model User */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Пользователь: ' . $this->title;
YiiAsset::register($this);
?>
<div class="nav-tabs-custom">
    <div class="tab-content">
        <p>
            <?= ModerationButtons::widget(['user' => $model])?>

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
                [
                    'label' => 'Дата создания',
                    'attribute' => 'created_at',
                    'value' => function(User $user) {
                        return Yii::$app->formatter->asDatetime($user->created_at, 'php:Y-m-d H:i:s');
                    }
                ],
                [
                    'label' => 'Дата создания',
                    'attribute' => 'updated_at',
                    'value' => function(User $user) {
                        return Yii::$app->formatter->asDatetime($user->created_at, 'php:Y-m-d H:i:s');
                    },
                    'visible' => isset($model->updated_at)
                ],
            ],
        ]) ?>
    </div>
</div>