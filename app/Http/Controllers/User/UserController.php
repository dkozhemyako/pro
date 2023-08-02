<?php

namespace App\Http\Controllers\User;

use App\Http\Requests\User\UserLoginRequest;
use App\Http\Resources\User\UserResource;
use App\Services\User\LoginDTO;
use App\Services\User\UserLoginService;

class UserController
{
    public function __construct(
        protected UserLoginService $userLoginService,
    ) {
    }

    public function login(UserLoginRequest $request): UserResource
    {
        $dto = $this->userLoginService->handle(new LoginDTO(...$request->validated()));
        $userResource = new UserResource
        (
            $dto->getUser()
        );

        return $userResource->additional([

            'Bearer' => $dto->getToken(),
        ]);
    }
}
