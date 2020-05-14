<?php

namespace core\forms\comment;

use yii\base\Model;

class CommentForm extends Model
{
    public $text;
    public $property;
    public $companyId;

    public function rules(): array
    {
        return [
            [['text', 'property'], 'required'],
            [['text', 'property'], 'string'],
            ['companyId', 'integer']
        ];
    }
}