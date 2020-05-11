<?php

use console\controllers\RoleController;
use core\entities\Company;
use frontend\forms\CompanySearch;
use yii\data\ArrayDataProvider;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;

/** @var $dataProvider ArrayDataProvider */
/** @var $searchModel CompanySearch */

$this->title = 'Компании';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-contact">
    <?php if (Yii::$app->user->can(RoleController::ADMIN)):?>
        <p>
            <?= Html::a('Создать компанию', ['create'], ['class' => 'btn btn-success']) ?>
        </p>
    <?php endif;?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'label' => 'Название компании',
                'attribute' => 'name',
                'value' => function(Company $company) {
                    return Html::a($company->name, ['view', 'id' => $company->id]);
                },
                'format' => 'raw'
            ],
            'inn',
            [
                'label' => 'Дата создания',
                'attribute' => 'created_at',
                'value' => function(Company $company) {
                    return Yii::$app->formatter->asDatetime($company->created_at, 'php:Y-m-d H:i:s');
                }
            ],

            ['class' => ActionColumn::class],
        ],
    ]); ?>

</div>
