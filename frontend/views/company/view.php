<?php

use core\entities\Company;
use yii\helpers\Html;

/** @var $model Company */

$this->title = 'Просмотр компании: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Компании', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-contact">
    <h1><?= Html::encode($this->title) ?></h1>

</div>