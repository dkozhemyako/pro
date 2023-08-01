<?php

namespace App\Repositories\Users;


use App\Repositories\Users\Iterators\UserIterator;
use Illuminate\Support\Facades\DB;

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
}
