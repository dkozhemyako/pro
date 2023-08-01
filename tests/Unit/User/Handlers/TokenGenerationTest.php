<?php

namespace Tests\Unit\User\Handlers;

use App\Services\User\CreateTokenUserService;
use App\Services\User\Handlers\TokenGenerationHandler;
use App\Services\User\LoginDTO;
use Laravel\Passport\PersonalAccessTokenResult;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

class TokenGenerationTest extends TestCase
{
    protected TokenGenerationHandler $tokenGenerationHandler;
    protected LoginDTO $loginDTO;
    protected CreateTokenUserService $createTokenUserService;

    protected PersonalAccessTokenResult $personalAccessTokenResult;

    /**
     * @throws Exception
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->createTokenUserService = $this->createMock(CreateTokenUserService::class);
        $this->loginDTO = $this->createMock(LoginDTO::class);
        $this->personalAccessTokenResult = $this->createMock(PersonalAccessTokenResult::class);
        $this->tokenGenerationHandler = new TokenGenerationHandler(
            $this->createTokenUserService
        );
    }

    public function testHandle(): void
    {
        $this->loginDTO
            ->expects(self::once())
            ->method('setToken')
            ->with($this->personalAccessTokenResult);

        $this->createTokenUserService
            ->expects(self::once())
            ->method('handle')
            ->willReturn($this->personalAccessTokenResult);

        $resultService = $this->tokenGenerationHandler->handle
        (
            $this->loginDTO,
            function (LoginDTO $loginDTO) {
                return $loginDTO;
            }
        );

        $this->assertSame($resultService, $this->loginDTO);
    }
}
