<?php

namespace Tests\Unit\User\Handlers;

use App\Repositories\Users\Iterators\UserIterator;
use App\Services\User\GetAuthUserService;
use App\Services\User\Handlers\GetAuthUserHandler;
use App\Services\User\LoginDTO;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

class GetAuthUserTest extends TestCase
{
    protected GetAuthUserHandler $getAuthUserHandler;
    protected LoginDTO $loginDTO;
    protected GetAuthUserService $getAuthUserService;

    protected UserIterator $userIterator;

    /**
     * @throws Exception
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->getAuthUserService = $this->createMock(GetAuthUserService::class);
        $this->loginDTO = $this->createMock(LoginDTO::class);
        $this->userIterator = $this->createMock(UserIterator::class);
        $this->GetAuthUserHandler = new GetAuthUserHandler(
            $this->getAuthUserService
        );
    }

    public function testHandle(): void
    {
        $this->loginDTO
            ->expects(self::once())
            ->method('setUser')
            ->with($this->userIterator);

        $this->getAuthUserService
            ->expects(self::once())
            ->method('handle')
            ->willReturn($this->userIterator);

        $resultService = $this->GetAuthUserHandler->handle
        (
            $this->loginDTO,
            function (LoginDTO $loginDTO) {
                return $loginDTO;
            }
        );

        $this->assertSame($resultService, $this->loginDTO);
    }
}
