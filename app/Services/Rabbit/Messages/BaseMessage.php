<?php

namespace App\Services\Rabbit\Messages;

use App\Services\Rabbit\Messages\Handlers\CheckCarbonValueHandler;
use App\Services\Rabbit\Messages\Handlers\CheckDefaultValueHandler;
use App\Services\Rabbit\Messages\Handlers\CheckEnumValueHandler;
use App\Services\Rabbit\Messages\Handlers\CheckNullValueHandler;
use Illuminate\Pipeline\Pipeline;
use JsonSerializable;
use ReflectionClass;

class BaseMessage implements JsonSerializable
{
    protected const HANDLERS = [
        CheckEnumValueHandler::class,
        CheckCarbonValueHandler::class,
        CheckDefaultValueHandler::class,
        CheckNullValueHandler::class,
    ];

    protected Pipeline $pipeline;

    public function __construct(object $data) {

        {
            $reflect = new ReflectionClass($this);

            foreach ($reflect->getProperties() as $property) {
                $messagesDTO = new MessagesDTO(
                    $property->getName(),
                    $property->getType()->getName(),
                    $property,
                    $data
            );

                $this->pipeline = new Pipeline();

                $result = $this->pipeline
                ->send($messagesDTO)
                ->through(self::HANDLERS)
                ->thenReturn();

                $propertyName = $property->getName();
                $this->$propertyName = $result->getValue();
            }
        }
    }

    public function jsonSerialize(): array
    {
        return get_object_vars($this);
    }
}
