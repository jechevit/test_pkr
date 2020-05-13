<?php

use core\entities\Company;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var $model Company */

$this->title = 'Просмотр компании: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Компании', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-contact">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="box">
        <div class="box-body">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    [
                        'label' => 'Название компании',
                        'attribute' => 'name',
                    ],
                    [
                        'label' => 'ИНН',
                        'attribute' => 'inn',
                    ],
                    [
                        'label' => 'Описание компании',
                        'attribute' => 'description',
                        'visible' => isset($model->description),
                    ],
                    [
                        'label' => 'Телефон',
                        'attribute' => 'phone',
                        'visible' => isset($model->phone),
                    ],
                    [
                        'label' => 'Директор компании',
                        'value' => function(Company $company) {
                            return $company->director->getFullName();
                        }
                    ],
                    [
                        'label' => 'Адрес компании',
                        'value' => function(Company $company) {
                            return $company->address->getAddress();
                        }
                    ],
                    [
                        'label' => 'Дата создания',
                        'attribute' => 'created_at',
                        'value' => function(Company $company) {
                            return Yii::$app->formatter->asDatetime($company->created_at, 'php:Y-m-d H:i:s');
                        }
                    ],
                ],
            ])?>
        </div>
    </div>

</div>