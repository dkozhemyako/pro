<?php

namespace App\Services\Rabbit\Messages\Handlers;

use App\Services\Rabbit\Messages\Interfaces\BuilderInterface;
use App\Services\Rabbit\Messages\MessagesDTO;
use Closure;

class CheckEnumValueHandler implements BuilderInterface
{


    public function handle(MessagesDTO $messagesDTO, Closure $next): MessagesDTO
    {
        if (enum_exists($messagesDTO->getType())) {
            $propertyName = $messagesDTO->getPropertyName();
            $value = $messagesDTO->getData()->$propertyName;

            $messagesDTO->setValue($messagesDTO->getType()::from($value));
            return $messagesDTO;
        }

        return $next($messagesDTO);
    }
}
