<?php

namespace core\forms;

use core\entities\Director;
use yii\base\Model;

class DirectorForm extends Model
{
    public $firstName;
    public $secondName;
    public $patronymic;

    public function __construct(Director $director = null, $config = [])
    {
        if ($director) {
            $this->firstName = $director->firstName;
            $this->secondName = $director->secondName;
            $this->patronymic = $director->patronymic;
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['firstName', 'secondName'], 'required'],
            [['firstName', 'secondName', 'patronymic'], 'string'],
        ];
    }
}