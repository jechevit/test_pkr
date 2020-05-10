<?php

namespace core\entities;

class Director
{
    public $firstName;
    public $secondName;
    public $patronymic;

    /**
     * Director constructor.
     * @param $firstName
     * @param $secondName
     * @param $patronymic
     */
    public function __construct(
        $firstName,
        $secondName,
        $patronymic = null
    )
    {
        $this->firstName = $firstName;
        $this->secondName = $secondName;
        $this->patronymic = $patronymic;
    }

    /**
     * @return string
     */
    public function getFullName(): string
    {
        return "{$this->firstName} {$this->secondName} {$this->patronymic}";
    }
}