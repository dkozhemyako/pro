<?php

namespace Tests\Unit\User\Handlers;

use App\Repositories\WhiteListIp\WhiteListIpRepository;
use App\Services\User\Handlers\CheckWhiteListIpHandler;
use App\Services\User\LoginDTO;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

class CheckWhiteListIpTest extends TestCase
{
    protected CheckWhiteListIpHandler $checkWhiteListIpHandler;
    protected WhiteListIpRepository $whiteListIpRepository;
    protected LoginDTO $loginDTO;

    /**
     * @throws Exception
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->whiteListIpRepository = $this->createMock(WhiteListIpRepository::class);
        $this->loginDTO = $this->createMock(LoginDTO::class);
        $this->CheckWhiteListIpHandler = new CheckWhiteListIpHandler(
            $this->whiteListIpRepository
        );
    }

    public function testHandleFalse(): void
    {
        $this->whiteListIpRepository
            ->expects(self::once())
            ->method('existByUserIdByIp')
            ->with(
                $this->loginDTO->getUser()->getId(),
                $this->loginDTO->getIp()
            )
            ->willReturn(false);

        $this->loginDTO
            ->expects(self::once())
            ->method('setError');


        $resultService = $this->CheckWhiteListIpHandler->handle
        (
            $this->loginDTO,
            function (LoginDTO $loginDTO) {
                return $loginDTO;
            }
        );

        $this->assertSame($resultService, $this->loginDTO);
    }

    public function testHandleTrue(): void
    {
        $this->whiteListIpRepository
            ->expects(self::once())
            ->method('existByUserIdByIp')
            ->with(
                $this->loginDTO->getUser()->getId(),
                $this->loginDTO->getIp()
            )
            ->willReturn(true);

        $this->loginDTO
            ->expects(self::never())
            ->method('setError');


        $resultService = $this->CheckWhiteListIpHandler->handle
        (
            $this->loginDTO,
            function (LoginDTO $loginDTO) {
                return $loginDTO;
            }
        );

        $this->assertSame($resultService, $this->loginDTO);
    }

}
