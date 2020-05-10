<?php

namespace core\behaviors;

use core\entities\Address;
use yii\base\Behavior;
use yii\base\Event;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

class AddressBehavoir extends Behavior
{
    public $attribute = 'address';
    public $jsonAttribute = 'address_json';

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
        $model->{$this->attribute} = new Address(
            ArrayHelper::getValue($meta, 'country'),
            ArrayHelper::getValue($meta, 'city'),
            ArrayHelper::getValue($meta, 'street'),
            ArrayHelper::getValue($meta, 'house')
        );
    }

    public function onBeforeSave(Event $event): void
    {
        $model = $event->sender;
        $model->setAttribute($this->jsonAttribute, Json::encode([
            'country' => $model->{$this->attribute}->country,
            'city' => $model->{$this->attribute}->city,
            'street' => $model->{$this->attribute}->street,
            'house' => $model->{$this->attribute}->house,
        ]));
    }
}