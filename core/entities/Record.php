<?php

namespace core\entities;

use core\helpers\CommentHelper;
use DateTimeImmutable;

/**
 * Class Record
 * @package core\entities
 */
class Record
{
    /**
     * @var string
     */
    private $property;
    /**
     * @var string
     */
    private $text;
    /**
     * @var DateTimeImmutable
     */
    private $created_at;

    /**
     * Record constructor.
     * @param string $property
     * @param string $text
     * @param DateTimeImmutable $created_at
     */
    public function __construct(string $property, string $text, DateTimeImmutable $created_at)
    {
        $this->property = CommentHelper::propertyValue($property);
        $this->text = $text;
        $this->created_at = $created_at;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @return int
     */
    public function getProperty(): int
    {
        return $this->property;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getCreated_at(): DateTimeImmutable
    {
        return $this->created_at;
    }
}