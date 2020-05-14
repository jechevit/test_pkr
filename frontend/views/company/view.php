<?php

use core\database\Column;
use core\entities\Comment;
use core\entities\Company;
use core\helpers\CommentHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var $model Company */

$this->title = 'Просмотр компании: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Компании', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="site-contact">
    <h1><?= Html::encode($this->title) . CommentHelper::button($model, Column::COMMON)?></h1>

    <div class="box">
        <div class="box-body">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    [
                        'label' => 'Название компании',
                        'value' => function(Company $company) {
                            return $company->name . CommentHelper::button($company, Column::NAME);
                        },
                        'format' => 'raw'
                    ],
                    [
                        'label' => 'ИНН',
                        'value' => function(Company $company) {
                            return $company->inn . CommentHelper::button($company, Column::INN);
                        },
                        'format' => 'raw'
                    ],
                    [
                        'label' => 'Описание компании',
                        'attribute' => 'description',
                        'visible' => isset($model->description),
                        'value' => function(Company $company) {
                            return $company->description . CommentHelper::button($company, Column::DESCRIPTION);
                        },
                        'format' => 'raw'
                    ],
                    [
                        'label' => 'Телефон',
                        'attribute' => 'phone',
                        'visible' => isset($model->phone),
                        'value' => function(Company $company) {
                            return $company->phone . CommentHelper::button($company, Column::PHONE);
                        },
                        'format' => 'raw'
                    ],
                    [
                        'label' => 'Директор компании',
                        'value' => function(Company $company) {
                            return $company->director->getFullName() . CommentHelper::button($company, Column::DIRECTOR_JSON);
                        },
                        'format' => 'raw'
                    ],
                    [
                        'label' => 'Адрес компании',
                        'value' => function(Company $company) {
                            return $company->address->getAddress() . CommentHelper::button($company, Column::ADDRESS_JSON);
                        },
                        'format' => 'raw'
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
        <?php if (!empty($model->comments)):?>
        <div class="comments">
            <h3>Комментарии:</h3>
            <?php /** @var Comment $comment */
            foreach ($model->comments as $comment):?>

                <div class="panel panel-default">
                    <div class="panel-heading clearfix">
                        <div class="panel-title pull-left">
                            <p class="panel-title">
                            <strong><?= $comment->user->username?></strong> прокомментировал <?= CommentHelper::getNameOfProperty($comment->getRecord()->getProperty())?>:

                            </p>
                        </div>
                        <div class="panel-title pull-right">
                            Создано: <?= Yii::$app->formatter->asDatetime($comment->getRecord()->getCreated_at(), 'php:d.m.yy H:i:s') ?>
                        </div>
                    </div>

                    <div class="panel-body">
                        <?= $comment->getRecord()->getText()?>
                    </div>
                </div>

            <?php endforeach;?>
        </div>
        <?php endif;?>
    </div>

</div>