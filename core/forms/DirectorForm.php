<?php

namespace core\forms;

use core\entities\Company;
use yii\base\Model;

class DirectorForm extends Model
{
    public $fistName;
    public $secondName;
    public $patronymic;

    public function __construct(Company $company = null, $config = [])
    {
        if ($company) {
            $this->fistName = $company->director->firstName;
            $this->secondName = $company->director->secondName;
            $this->patronymic = $company->director->patronymic;
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