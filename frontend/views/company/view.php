<?php

use core\database\Column;
use core\entities\Comment;
use core\entities\Company;
use core\helpers\CommentHelper;
use frontend\widgets\CommentWidget;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var $model Company */

$this->title = 'Просмотр компании: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Компании', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="site-contact">
    <h2><?= Html::encode($this->title) . CommentWidget::widget(['company' => $model, 'property' => Column::COMMON]) ?></h2>
    <div class="box">
        <div class="box-body">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    [
                        'label' => 'Название компании',
                        'value' => function(Company $company) {
                            return $company->name . CommentWidget::widget(['company' => $company, 'property' => Column::NAME]);
                        },
                        'format' => 'raw'
                    ],
                    [
                        'label' => 'ИНН',
                        'value' => function(Company $company) {
                            return $company->inn . CommentWidget::widget(['company' => $company, 'property' => Column::INN]);
                        },
                        'format' => 'raw'
                    ],
                    [
                        'label' => 'Описание компании',
                        'attribute' => 'description',
                        'visible' => isset($model->description),
                        'value' => function(Company $company) {
                            return $company->description . CommentWidget::widget(['company' => $company, 'property' => Column::DESCRIPTION]);
                        },
                        'format' => 'raw'
                    ],
                    [
                        'label' => 'Телефон',
                        'attribute' => 'phone',
                        'visible' => isset($model->phone),
                        'value' => function(Company $company) {
                            return $company->phone . CommentWidget::widget(['company' => $company, 'property' => Column::PHONE]);
                        },
                        'format' => 'raw'
                    ],
                    [
                        'label' => 'Директор компании',
                        'value' => function(Company $company) {
                            return $company->director->getFullName() . CommentWidget::widget(['company' => $company, 'property' => Column::DIRECTOR_JSON]);
                        },
                        'format' => 'raw'
                    ],
                    [
                        'label' => 'Адрес компании',
                        'value' => function(Company $company) {
                            return $company->address->getAddress() . CommentWidget::widget(['company' => $company, 'property' => Column::ADDRESS_JSON]);
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