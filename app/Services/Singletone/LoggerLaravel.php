<?php

namespace App\Services\Singletone;

class LoggerLaravel
{
    protected array $logs = [];
    public function logMessage(string $message): void
    {
        $this->logs[] = [time() => $message];
    }

    public function getLog(): string
    {
        return json_encode($this->logs);
    }

}
