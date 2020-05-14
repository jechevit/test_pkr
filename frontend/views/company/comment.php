<?php

use core\entities\Company;
use core\forms\comment\CommentForm;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var $model CommentForm */
/** @var $company Company */

?>
<?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>

<?= $form->field($model, 'text')->textInput(['autofocus' => true]) ?>

<div class="form-group">
    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
</div>

<?php ActiveForm::end(); ?>

