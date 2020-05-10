<?php

namespace core\behaviors;

use core\entities\Director;
use yii\base\Behavior;
use yii\base\Event;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

class DirectorBehavoir extends Behavior
{
    public $attribute = 'director';
    public $jsonAttribute = 'director_json';

    public function events(): array
    {
        return [
            ActiveRecord::EVENT_AFTER_FIND => 'onAfterFind',
            ActiveRecord::EVENT_BEFORE_INSERT => 'onBeforeSave',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'onBeforeSave',
        ];
    }

    public function onAfterFind(Event $event): void
    {
        $model = $event->sender;
        $meta = Json::decode($model->getAttribute($this->jsonAttribute));
        $model->{$this->attribute} = new Director(
            ArrayHelper::getValue($meta, 'firstName'),
            ArrayHelper::getValue($meta, 'secondName'),
            ArrayHelper::getValue($meta, 'patronymic')
        );
    }

    public function onBeforeSave(Event $event): void
    {
        $model = $event->sender;
        $model->setAttribute($this->jsonAttribute, Json::encode([
            'firstName' => $model->{$this->attribute}->firstName,
            'secondName' => $model->{$this->attribute}->secondName,
            'patronymic' => $model->{$this->attribute}->patronymic,
        ]));
    }
}