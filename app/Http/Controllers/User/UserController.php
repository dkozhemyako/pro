<?php

namespace App\Http\Controllers\User;

use App\Http\Requests\User\UserLoginRequest;
use App\Http\Resources\User\UserResource;
use App\Services\User\UserLoginService;

class UserController
{
    public function __construct(
        protected UserLoginService $userLoginService,
    ) {
    }

    public function login(UserLoginRequest $request): UserResource
    {
        $token = $this->userLoginService->login
        (
            $request->validated()
        );

        $userResource = new UserResource
        (
            $this->userLoginService->getById
            (
                auth()->user()->id
            )
        );

        return $userResource->additional([
            'Bearer' => $token,
        ]);
        //route
    }
}
