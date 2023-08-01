<?php

namespace Tests\Unit\User\Handlers;

use App\Repositories\LastListIp\LastListIpRepository;
use App\Services\User\Handlers\RecordingLastIpHandler;
use App\Services\User\LoginDTO;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

class RecordingLastIpTest extends TestCase
{
    protected RecordingLastIpHandler $recordingLastIpHandler;
    protected LastListIpRepository $lastListIpRepository;
    protected LoginDTO $loginDTO;

    /**
     * @throws Exception
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->lastListIpRepository = $this->createMock(LastListIpRepository::class);
        $this->loginDTO = $this->createMock(LoginDTO::class);
        $this->recordingLastIpHandler = new RecordingLastIpHandler(
            $this->lastListIpRepository
        );
    }

    public function testHandle(): void
    {
        $this->lastListIpRepository
            ->expects(self::once())
            ->method('store')
            ->with(
                $this->loginDTO->getUser()->getId(),
                $this->loginDTO->getIp(),
            );

        $resultService = $this->recordingLastIpHandler->handle
        (
            $this->loginDTO,
            function (LoginDTO $loginDTO) {
                return $loginDTO;
            }
        );

        $this->assertSame($resultService, $this->loginDTO);
    }
}
