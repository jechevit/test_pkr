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

    var_dump((Yii::$app->authManager->getRolesByUser(Yii::$app->user->id)));
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

        <div class="comments">
            <?php /** @var Comment $comment */
            foreach ($model->comments as $comment):?>
                <div class="media">
                    <div class="media-body">
                        <h4 class="media-heading"><?= $comment->user->username?></h4>
                        <p>
                            <?php var_dump($comment->comments_json);?>
                        </p>
                        ...
                    </div>
                </div>
            <?php endforeach;?>
        </div>
    </div>

</div>