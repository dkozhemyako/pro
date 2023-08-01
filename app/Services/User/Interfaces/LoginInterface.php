<?php

namespace App\Services\User\Interfaces;

use App\Services\User\LoginDTO;
use Closure;

interface LoginInterface
{
    public function handle(LoginDTO $loginDTO, Closure $next): LoginDTO;
}
