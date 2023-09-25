<?php

namespace App\Services\Rabbit\Messages\Handlers;

use App\Services\Rabbit\Messages\Interfaces\BuilderInterface;
use App\Services\Rabbit\Messages\MessagesDTO;
use Closure;
use Illuminate\Support\Carbon;

class CheckCarbonValueHandler implements BuilderInterface
{

    public function handle(MessagesDTO $messagesDTO, Closure $next): MessagesDTO
    {
        if ($messagesDTO->getType() === Carbon::class) {
            $propertyName = $messagesDTO->getPropertyName();
            $value = $messagesDTO->getData()->$propertyName;

            $messagesDTO->setValue(Carbon::parse($value));
            return $messagesDTO;
        }

        return $next($messagesDTO);
    }
}
