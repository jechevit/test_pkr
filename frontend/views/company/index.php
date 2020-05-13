<?php

use console\controllers\RoleController;
use core\entities\Company;
use frontend\forms\CompanySearch;
use yii\data\ArrayDataProvider;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var $dataProvider ArrayDataProvider */
/** @var $searchModel CompanySearch */

$this->title = 'Компании';
$this->params['breadcrumbs'][] = $this->title;

$companies = array_chunk($dataProvider->getModels(), 2);
?>

<div class="site-contact">
    <?php if (Yii::$app->user->can(RoleController::ADMIN)):?>
        <p>
            <?= Html::a('Создать компанию', ['create'], ['class' => 'btn btn-success']) ?>
        </p>
    <?php endif;?>

   <?php foreach ($companies as $row):?>
       <div class="row">
           <?php /** @var Company $company */
           foreach ($row as $company):?>
               <div class="col-md-6">
                   <div class="panel panel-default ">
                       <div class="panel-heading">
                           <h3 class="panel-title"><?= Html::a($company->name, ['view', 'id' => $company->id])?></h3>
                       </div>
                       <div class="panel-body">
                           <?= DetailView::widget([
                               'model' => $company,
                               'attributes' => [
                                   [
                                       'label' => 'ИНН',
                                       'attribute' => 'inn',
                                   ],
                                   [
                                       'label' => 'Телефон',
                                       'attribute' => 'phone',
                                       'visible' => isset($company->phone),
                                   ],
                                   [
                                       'label' => 'Директор компании',
                                       'value' => function(Company $company) {
                                           return $company->director->getFullName();
                                       }
                                   ],
                               ],
                           ])?>
                       </div>
                   </div>
               </div>
           <?php endforeach;?>
       </div>
   <?php endforeach;?>

</>
