<?php

namespace core\forms;

use core\entities\Address;
use yii\base\Model;

class AddressForm extends Model
{
    public $country;
    public $city;
    public $street;
    public $house;

    public function __construct(Address $address = null, $config = [])
    {
        if ($address){
            $this->country = $address->country;
            $this->city = $address->city;
            $this->street = $address->street;
            $this->house = $address->house;
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['country', 'city', 'street', 'house'], 'required'],
            [['country', 'city', 'street'], 'string'],
            [['house'], 'integer'],
        ];
    }
}