<?php

namespace core\forms;

use yii\base\Model;

class AddressForm extends Model
{
    public $country;
    public $city;
    public $street;
    public $house;

    public function rules()
    {
        return [
            [['country', 'city', 'street', 'house'], 'required'],
            [['country', 'city', 'street'], 'string'],
            [['house'], 'integer'],
        ];
    }
}