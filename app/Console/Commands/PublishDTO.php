<?php

namespace App\Console\Commands;


use JsonSerializable;

class PublishDTO implements JsonSerializable
{

    public function __construct
    (
        protected int $id,
        protected string $name,
    ) {
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }


}
