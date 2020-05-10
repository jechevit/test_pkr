<?php

namespace core\entities;

use core\behaviors\AddressBehavoir;
use core\behaviors\DirectorBehavoir;
use core\database\Table;
use yii\db\ActiveRecord;

/**
 * Class Company
 * @package core\entities
 *
 * @property int $id
 * @property string $name
 * @property int $inn
 *
 */
class Company extends ActiveRecord
{
    /**
     * @var Director
     */
    public $director;
    /**
     * @var Address
     */
    public $address;

    public static function create(
        $name,
        $inn,
        Director $director,
        Address $address
    ): self
    {
        $company = new static();
        $company->name = $name;
        $company->inn = $inn;
        $company->changeDirector($director);
        $company->changeAddress($address);

        return $company;
    }

    public function edit(
        $name,
        $inn,
        Director $director,
        Address $address
    ): void
    {
        $this->name = $name;
        $this->inn = $inn;
        $this->changeDirector($director);
        $this->changeAddress($address);
    }

    /**
     * @param Director $director
     */
    private function changeDirector(Director $director): void
    {
        $this->director = $director;
    }

    /**
     * @param Address $address
     */
    private function changeAddress(Address $address): void
    {
        $this->address = $address;
    }

    public static function tableName()
    {
        return Table::COMPANIES;
    }

    public function behaviors()
    {
        return [
            AddressBehavoir::class,
            DirectorBehavoir::class,
        ];
    }
}