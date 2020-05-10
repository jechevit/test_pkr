<?php

use core\forms\CompanyForm;
use yii\helpers\Html;

/** @var $model CompanyForm */

$this->title = 'Создание компании';
$this->params['breadcrumbs'][] = ['label' => 'Компании', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-contact">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model
    ])?>
</div>