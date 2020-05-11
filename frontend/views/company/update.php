<?php

use core\entities\Company;
use core\forms\CompanyForm;
use yii\helpers\Html;

/** @var $model CompanyForm */
/** @var $company Company */

$this->title = 'Редактирование компании: ' . $company->name;
$this->params['breadcrumbs'][] = ['label' => 'Компании', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $company->name, 'url' => ['view', 'id' => $company->id]];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-contact">

    <?= Html::a('Удалить компанию', ['delete', 'id' => $company->id], [
        'class' => 'btn btn-danger',
        'data' => [
            'confirm' => 'Are you sure you want to delete this item?',
            'method' => 'post',
        ],
    ]) ?>

    <?= $this->render('_form', [
        'model' => $model
    ])?>
</div>