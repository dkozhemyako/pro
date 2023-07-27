<?php

namespace Tests\Unit\User;

use App\Repositories\Users\Iterators\UserIterator;
use App\Repositories\Users\UserRepository;
use App\Services\User\UserLoginService;
use Laravel\Passport\PersonalAccessTokenResult;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

class UserLoginTest extends TestCase
{
    protected UserLoginService $userLoginService;
    protected UserRepository $userRepository;
    protected UserIterator $userIterator;

    protected PersonalAccessTokenResult $personalAccessTokenResult;

    /**
     * @throws Exception
     */
    public function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        $this->personalAccessTokenResult = $this->createMock(PersonalAccessTokenResult::class);
        $this->userIterator = $this->createMock(UserIterator::class);
        $this->userRepository = $this->createMock(UserRepository::class);
        $this->userLoginService = new UserLoginService
        (
            $this->userRepository
        );
    }

    public function testGetById(): void
    {
        $id = 1;
        $resultRepository = $this->userIterator;
        $this->userRepository
            ->expects(self::once())
            ->method('getById')
            ->with($id)
            ->willReturn($resultRepository);

        $resultService = $this->userLoginService->getById($id);
        $this->assertSame($resultRepository, $resultService);
    }

    public function testLogin(): void
    {
        $validated =
            [
                'email' => 'test@test.com',
                'password' => '12345678',
            ];

        $this->userRepository
            ->expects(self::once())
            ->method('login')
            ->with($validated)
            ->willReturn(false);

        $this->userRepository
            ->expects(self::never())
            ->method('getToken');

        $resultService = $this->userLoginService->login($validated);
        $this->assertFalse($resultService);
    }

    public function testLoginGetToken(): void
    {
        $validated =
            [
                'email' => 'test@test.com',
                'password' => '12345678',
            ];

        $resultRepository = $this->personalAccessTokenResult;

        $this->userRepository
            ->expects(self::once())
            ->method('login')
            ->with($validated)
            ->willReturn(true);

        $this->userRepository
            ->expects(self::once())
            ->method('getToken')
            ->willReturn($resultRepository);

        $resultService = $this->userLoginService->login($validated);
        $this->assertSame($resultRepository, $resultService);
    }
}
