<?php

namespace App\Services\Singletone;

class LoggerPHP
{
    private static ?LoggerPHP $instance = null;
    protected array $logs = [];

    private function __construct(){

    }
    public static function getInstance(): ?LoggerPHP
    {
        if (self::$instance === null){
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function logMessage(string $message): void
    {
        $this->logs[] = [time() => $message];
    }

    public function getLog(): string
    {
        return json_encode($this->logs);
    }
}
