<?php

use core\entities\Company;
use core\forms\comment\CommentForm;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var $company Company */
/** @var $property string */
/** @var $model CommentForm */

Modal::begin([
    'header' => '<h4>Оставьте свой комментарий</h4>',
    'toggleButton' => [
        'label' => '  <span class="glyphicon glyphicon-plus" ></span>',
        'tag' => 'a',
    ],
]);

?>
<?php $form = ActiveForm::begin([
    'id' => 'comment-form',
    'action' => ['company/comment']
]); ?>

<?= $form->field($model, 'text')->textInput(['autofocus' => true])->label('Комментарий') ?>
<?= $form->field($model, 'property')->hiddenInput(['value' => $property])->label(false) ?>
<?= $form->field($model, 'companyId')->hiddenInput(['value' => $company->id])->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить!', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
    </div>
<?php ActiveForm::end(); ?>
<?php Modal::end() ?>