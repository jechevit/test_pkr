<?php


namespace core\helpers;


use core\database\Column;
use yii\helpers\ArrayHelper;

class CommentHelper
{
    public static function propertiesList(): array
    {
        return [
            Column::NAME => 1,
            Column::INN => 2,
            Column::DESCRIPTION => 3,
            Column::PHONE => 4,
            Column::ADDRESS_JSON => 5,
            Column::DIRECTOR_JSON => 6,
            Column::COMMON => 7,
        ];
    }

    public static function propertyValue(string $property): int
    {
        return ArrayHelper::getValue(self::propertiesList(), $property);
    }
}