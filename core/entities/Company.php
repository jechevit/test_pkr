<?php

namespace core\entities;

use core\behaviors\AddressBehavoir;
use core\behaviors\DirectorBehavoir;
use core\database\Table;
use core\entities\queries\CompanyQuery;
use DomainException;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class Company
 * @package core\entities
 *
 * @property int $id
 * @property string $name
 * @property int $inn
 * @property string $description
 * @property string $phone
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Comment[] $comments
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
        $description,
        $phone,
        Director $director,
        Address $address
    ): self
    {
        $company = new static();
        $company->name = $name;
        $company->inn = $inn;
        $company->description = $description;
        $company->phone = $phone;
        $company->changeDirector($director);
        $company->changeAddress($address);
        $company->created_at = time();

        return $company;
    }

    public function edit(
        $name,
        $inn,
        $description,
        $phone,
        Director $director,
        Address $address
    ): void
    {
        $this->name = $name;
        $this->inn = $inn;
        $this->description = $description;
        $this->phone = $phone;
        $this->changeDirector($director);
        $this->changeAddress($address);
        $this->updated_at = time();
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

    public function addComment($userId, $property, $text): Comment
    {
        $comments = $this->comments;
        $role = 'admin';
        $comments[] = $comment = Comment::create($userId, $role, $property, $text);
        $this->updateComments($comments);
        return $comment;
    }

    public function removeComment($id): void
    {
        $comments = $this->comments;
        foreach ($comments as $i => $comment) {
            if ($comment->isIdEqualTo($id)) {
                unset($comments[$i]);
                $this->updateComments($comments);
                return;
            }
        }
        throw new DomainException('Comment is not found.');
    }

    private function updateComments(array $comments): void
    {
        $this->comments = $comments;
    }

    public static function tableName()
    {
        return Table::COMPANIES;
    }

    public function getComments(): ActiveQuery
    {
        return $this->hasMany(Comment::class, ['company_id' => 'id']);
    }

    public function behaviors()
    {
        return [
            AddressBehavoir::class,
            DirectorBehavoir::class,
        ];
    }

    public static function find(): CompanyQuery
    {
        return new CompanyQuery(static::class);
    }
}