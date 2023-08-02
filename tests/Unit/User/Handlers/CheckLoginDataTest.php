<?php

namespace Tests\Unit\User\Handlers;

use App\Services\User\Handlers\CheckLoginDataHandler;
use App\Services\User\LoginDTO;
use App\Services\User\LoginService;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

class CheckLoginDataTest extends TestCase
{
    protected CheckLoginDataHandler $checkLoginDataHandler;
    protected LoginService $loginService;
    protected LoginDTO $loginDTO;

    /**
     * @throws Exception
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->loginService = $this->createMock(LoginService::class);
        $this->loginDTO = $this->createMock(LoginDTO::class);
        $this->checkLoginDataHandler = new CheckLoginDataHandler(
            $this->loginService
        );
    }

    public function testHandleFalse(): void
    {
        $data = [
            'email' => $this->loginDTO->getEmail(),
            'password' => $this->loginDTO->getPassword(),
        ];

        $this->loginService
            ->expects(self::once())
            ->method('handle')
            ->with($data)
            ->willReturn(false);

        $this->loginDTO
            ->expects(self::once())
            ->method('setError');


        $resultService = $this->checkLoginDataHandler->handle
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
        $data = [
            'email' => $this->loginDTO->getEmail(),
            'password' => $this->loginDTO->getPassword(),
        ];

        $this->loginService
            ->expects(self::once())
            ->method('handle')
            ->with($data)
            ->willReturn(true);

        $this->loginDTO
            ->expects(self::never())
            ->method('setError');


        $resultService = $this->checkLoginDataHandler->handle
        (
            $this->loginDTO,
            function (LoginDTO $loginDTO) {
                return $loginDTO;
            }
        );

        $this->assertSame($resultService, $this->loginDTO);
    }
}
