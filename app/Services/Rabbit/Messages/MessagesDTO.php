<?php

namespace App\Services\Rabbit\Messages;

use ReflectionProperty;

class MessagesDTO
{

    protected $value;

    public function __construct(
        protected string $propertyName,
        protected string $type,
        protected ReflectionProperty $property,
        protected object $data,

    ){}

    /**
     * @return mixed
     */
    public function getValue(): mixed
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function getPropertyName(): string
    {
        return $this->propertyName;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return ReflectionProperty
     */
    public function getProperty(): ReflectionProperty
    {
        return $this->property;
    }

    /**
     * @return object
     */
    public function getData(): object
    {
        return $this->data;
    }

    /**
     * @param mixed $value
     */
    public function setValue(mixed $value): void
    {
        $this->value = $value;
    }




}


