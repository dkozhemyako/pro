<?php

namespace App\Services\User;

use App\Repositories\Users\Iterators\UserIterator;
use App\Repositories\Users\UserRepository;

class UserLoginService
{
    public function __construct(
        protected UserRepository $userRepository,
    ) {
    }

    public function getById(int $id): UserIterator
    {
        return $this->userRepository->getById($id);
    }

    public function login(array $validated)
    {
        if ($this->userRepository->login($validated) === false) {
            return 'error'; // Response code: 422
        }

        return $this->userRepository->getToken();
    }
}
