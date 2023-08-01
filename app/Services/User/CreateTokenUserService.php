<?php

namespace App\Services\User;

use App\Repositories\Users\UserRepository;
use Laravel\Passport\PersonalAccessTokenResult;

class CreateTokenUserService
{
    public function handle(): PersonalAccessTokenResult
    {
        return
            auth()
                ->user()
                ->createToken('app');
    }
}

