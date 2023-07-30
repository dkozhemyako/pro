<?php

namespace Numbers;

use App\Services\Numbers\EvenNumberService;
use PHPUnit\Framework\TestCase;

class EvenNumberTest extends TestCase
{
    protected EvenNumberService $evenNumberService;

    protected array $numbers;

    public function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->numbers = [
            '1',
            '2',
            '26'
        ];
        $this->evenNumberService = new EvenNumberService($this->numbers);
    }

    public function testEven()
    {
        $even = $this->evenNumberService->getEven();
        $this->assertSame(2, $even);
    }

}
