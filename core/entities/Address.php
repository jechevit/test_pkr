<?php

namespace core\entities;

/**
 * Class Address
 * @package core\entities
 */
class Address
{
    public $country;
    public $city;
    public $street;
    public $house;

    /**
     * Address constructor.
     * @param $country
     * @param $city
     * @param $street
     * @param $house
     */
    public function __construct(
        $country,
        $city,
        $street,
        $house
    )
    {
        $this->country = $country;
        $this->city = $city;
        $this->street = $street;
        $this->house = $house;
    }

    /**
     * @return string
     */
    public function getAddress(): string
    {
        return "{$this->country}, {$this->city}, {$this->street}, {$this->house}";
    }
}