<?php

namespace frontend\widgets;

use core\entities\Company;
use core\forms\comment\CommentForm;
use yii\base\Widget;

class CommentWidget extends Widget
{
    /**
     * @var Company
     */
    public $company;
    /**
     * @var string
     */
    public $property;

    public function run()
    {
        return $this->render('_modal', [
            'model' => new CommentForm(),
            'property' => $this->property,
            'company' => $this->company
        ]);
    }
}