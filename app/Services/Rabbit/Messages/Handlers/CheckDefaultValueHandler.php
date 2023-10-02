<?php

namespace App\Services\Rabbit\Messages\Handlers;

use App\Services\Rabbit\Messages\Interfaces\BuilderInterface;
use App\Services\Rabbit\Messages\MessagesDTO;
use Closure;

class CheckDefaultValueHandler implements BuilderInterface
{


    public function handle(MessagesDTO $messagesDTO, Closure $next): MessagesDTO
    {
        $propertyName = $messagesDTO->getPropertyName();

        if ($messagesDTO->getProperty()->hasDefaultValue() && isset($data->$propertyName) === false) {
            $messagesDTO->setValue($messagesDTO->getProperty()->getDefaultValue());
            return $messagesDTO;
        }

        return $next($messagesDTO);
    }

}
