<?php

namespace Numbers;

use App\Services\Numbers\EvenNumberService;
use App\Services\Numbers\LessNumberService;
use App\Services\Numbers\OddNumberService;
use App\Services\Numbers\OverEvenNumberService;
use PHPUnit\Framework\TestCase;

class OverEvenNumberTest extends TestCase
{
    protected OverEvenNumberService $overEvenNumberService;

    protected array $numbers;

    public function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->numbers = [
            '1',
            '2',
            '26'
        ];

        $this->overEvenNumberService = new OverEvenNumberService($this->numbers);
    }

    public function testOverEven()
    {
        $overEven = $this->overEvenNumberService->getOverEven();
        $this->assertSame(1, $overEven);
    }

}
