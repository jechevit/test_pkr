<?php

use core\forms\CompanyForm;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var $model CompanyForm */

?>
<?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>

<?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>

<?= $form->field($model, 'inn')->textInput() ?>
<?= $form->field($model, 'description')->textarea(['rows' => 3]) ?>
<?= $form->field($model, 'phone')->textInput() ?>

<?= $form->field($model->director, 'firstName') ?>
<?= $form->field($model->director, 'secondName') ?>
<?= $form->field($model->director, 'patronymic') ?>

<?= $form->field($model->address, 'country') ?>
<?= $form->field($model->address, 'city') ?>
<?= $form->field($model->address, 'street') ?>
<?= $form->field($model->address, 'house') ?>


<div class="form-group">
    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
</div>

<?php ActiveForm::end(); ?>
