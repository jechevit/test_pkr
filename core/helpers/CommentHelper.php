<?php

namespace core\helpers;

use core\database\Column;
use core\entities\Company;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class CommentHelper
{
    const PROPERTY_NAME = 1;
    const PROPERTY_INN = 2;
    const PROPERTY_DESCRIPTION = 3;
    const PROPERTY_PHONE = 4;
    const PROPERTY_ADDRESS_JSON = 5;
    const PROPERTY_DIRECTOR_JSON = 6;
    const PROPERTY_COMMON = 7;


    public static function propertyValue(string $property)
    {
        return ArrayHelper::getValue(self::propertiesList(), $property);
    }

    public static function propertiesList(): array
    {
        return [
            Column::NAME => self::PROPERTY_NAME,
            Column::INN => self::PROPERTY_INN,
            Column::DESCRIPTION => self::PROPERTY_DESCRIPTION,
            Column::PHONE => self::PROPERTY_PHONE,
            Column::ADDRESS_JSON => self::PROPERTY_ADDRESS_JSON,
            Column::DIRECTOR_JSON => self::PROPERTY_DIRECTOR_JSON,
            Column::COMMON => self::PROPERTY_COMMON,
        ];
    }

    public static function propertyString(string $property)
    {
        return ArrayHelper::getValue(self::propertiesStrings(), $property);
    }

    public static function propertiesStrings(): array
    {
        return [
            self::PROPERTY_NAME => Column::NAME,
            self::PROPERTY_INN => Column::INN,
            self::PROPERTY_DESCRIPTION => Column::DESCRIPTION,
            self::PROPERTY_PHONE => Column::PHONE,
            self::PROPERTY_ADDRESS_JSON => Column::ADDRESS_JSON,
            self::PROPERTY_DIRECTOR_JSON => Column::DIRECTOR_JSON,
            self::PROPERTY_COMMON => Column::COMMON,
        ];
    }

    public static function button(Company $company, string $property)
    {
        return ' ' . Html::a(
            '<span class="glyphicon glyphicon-plus" ></span>',
            ['comment', 'id' => $company->id, 'property' => $property],
            ['title' => 'Добавить комментарий']
        );
    }
}