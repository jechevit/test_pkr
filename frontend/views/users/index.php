<?php

use core\entities\User;
use frontend\forms\UserSearch;
use yii\helpers\Html;
use yii\grid\GridView;
use core\helpers\UserHelper;
use yii\grid\ActionColumn;

/* @var $this yii\web\View */
/* @var $searchModel UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Пользователи';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="nav-tabs-custom">
    <div class="tab-content">
        <p>
            <?= Html::a('Создать пользователя', ['create'], ['class' => 'btn btn-success']) ?>
        </p>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                [
                    'attribute' => 'username',
                    'label' => 'username',
                    'value' => function(User $model){
                        return Html::a($model->username, ['view', 'id' => $model->id]);
                    },
                    'format' => 'raw'
                ],
                'email',
                [
                    'attribute' => 'status',
                    'filter' => UserHelper::statusList(),
                    'value' => function (User $model) {
                        return UserHelper::statusLabel($model->status);
                    },
                    'format' => 'raw',
                ],

                ['class' => ActionColumn::class],
            ],
        ]); ?>

    </div>
</div>
