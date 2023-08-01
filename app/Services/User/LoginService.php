<?php

namespace App\Services\User;

class LoginService
{
    public function handle(array $data): bool
    {
        return auth()->attempt($data);
    }
}

