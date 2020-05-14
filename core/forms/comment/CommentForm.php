<?php


namespace core\forms\comment;


use yii\base\Model;

class CommentForm extends Model
{
    public $text;

    public function rules(): array
    {
        return [
            [['text'], 'required'],
            [['text'], 'string'],
        ];
    }
}