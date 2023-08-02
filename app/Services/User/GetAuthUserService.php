<?php

namespace App\Services\User;

use App\Repositories\Users\Iterators\UserIterator;
use App\Repositories\Users\UserRepository;

class GetAuthUserService
{
    public function __construct(
        protected UserRepository $userRepository,
    ) {
    }

    public function handle(): UserIterator
    {
        return $this->userRepository->getById
        (
            auth()->user()->id
        );
    }
}

