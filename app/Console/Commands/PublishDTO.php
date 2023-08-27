<?php

namespace App\Console\Commands;


use JsonSerializable;

class PublishDTO implements JsonSerializable
{

    public function __construct
    (
        protected array|string $array
    ) {
    }

    public function jsonSerialize(): mixed
    {
        return $this->array;
    }

    public function getId()
    {
        return $this->array['id'];
    }

    public function getName()
    {
        return $this->array['name'];
    }

}
