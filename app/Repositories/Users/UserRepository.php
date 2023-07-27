<?php

namespace App\Repositories\Users;


use App\Repositories\Users\Iterators\UserIterator;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\PersonalAccessTokenResult;

class UserRepository
{
    public function getById(int $id): UserIterator
    {
        return new UserIterator(
            DB::table('users')
                ->where('id', '=', $id)
                ->first()
        );
        /*
        User::query()
            ->where('id', '=', $id)
            ->first();
        */
    }

    public function login(array $validated): bool
    {
        return auth()->attempt($validated);
    }

    public function getToken(): PersonalAccessTokenResult
    {
        return auth()
            ->user()
            ->createToken(config('app_name'));
    }
}
