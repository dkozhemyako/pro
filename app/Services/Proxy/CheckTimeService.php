<?php

namespace App\Services\Proxy;

class CheckTimeService
{
    protected float $startTime;
    protected float $endTime;

    public function getDifTime(): float
    {
        return $this->endTime - $this->startTime;
    }

    /**
     * @param float $startTime
     */
    public function setStartTime(): void
    {
        $this->startTime = microtime(true);
    }

    /**
     * @param float $endTime
     */
    public function setEndTime(): void
    {
        $this->endTime = microtime(true);
    }


}


