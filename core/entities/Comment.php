<?php


namespace core\entities;

use core\database\Table;
use core\helpers\CommentHelper;
use DateTimeImmutable;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\Json;

/**
 * Class Comment
 * @package core\entities
 *
 * @property int $id
 * @property int $company_id
 * @property int $user_id
 * @property string $comments_json
 *
 * @property Company $company
 * @property User $user
 */
class Comment extends ActiveRecord
{
    /**
     * @var Record[]
     */
    private $comments = [];

    /**
     * @param int $userId
     * @param string $property
     * @param string $text
     * @return static
     */
    public static function create(
        int $userId,
        string $property,
        string $text
    ): self
    {
        $comment = new static();
        $comment->user_id = $userId;
        $comment->addComment($property, $text);
        return $comment;
    }

    /**
     * @param string $property
     * @param string $text
     */
    private function addComment(string $property, string $text): void
    {
        $this->comments[] = new Record(CommentHelper::propertyValue($property), $text, new DateTimeImmutable());
    }

    /**
     * @param $id
     * @return bool
     */
    public function isIdEqualTo($id): bool
    {
        return $this->id == $id;
    }

    public function getTextForProperty($property): string
    {
        $text = '';
        foreach ($this->comments as $record) {
            if ($record->getProperty() == CommentHelper::propertyValue($property)){
                $text = $record->getText();
            }
        }
        return $text;
    }

    public static function tableName()
    {
        return Table::COMMENTS;
    }

    public function getCompany(): ActiveQuery
    {
        return $this->hasOne(Company::class, ['id' => 'company_id']);
    }

    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function transactions(): array
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    public function afterFind(): void
    {
        $this->comments = array_map(function ($row) {
            return new Record(
                $row['property'],
                $row['text'],
                new DateTimeImmutable()
            );
        }, Json::decode($this->getAttribute('comments_json')));

        parent::afterFind();
    }

    public function beforeSave($insert): bool
    {
        $this->setAttribute('comments_json', Json::encode(array_map(function (Record $record) {
            return [
                'property' => CommentHelper::propertyString($record->getProperty()),
                'text' => $record->getText(),
                'created_at' => $record->getCreated_at()
            ];
        }, $this->comments)));

        return parent::beforeSave($insert);
    }
}