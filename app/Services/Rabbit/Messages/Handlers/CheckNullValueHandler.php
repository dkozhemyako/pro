<?php

namespace App\Services\Rabbit\Messages\Handlers;

use App\Services\Rabbit\Messages\Interfaces\BuilderInterface;
use App\Services\Rabbit\Messages\MessagesDTO;
use Closure;

class CheckNullValueHandler implements BuilderInterface
{

    public function handle(MessagesDTO $messagesDTO, Closure $next): MessagesDTO
    {
        $propertyName = $messagesDTO->getPropertyName();

        if($messagesDTO->getProperty()->getType()->allowsNull() && isset($data->$propertyName) === false){
            $messagesDTO->setValue(null);
            return $messagesDTO;
        }

        return $next($messagesDTO);
    }
}
