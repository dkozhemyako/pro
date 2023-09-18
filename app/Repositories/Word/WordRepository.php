<?php

namespace App\Repositories\Word;

use Illuminate\Support\Facades\DB;

class WordRepository
{
    public function store(WordDTO $wordDTO): void
    {
        DB::table('words_result')
            ->insert([
                'word' => $wordDTO->getWord(),
                'result' => $wordDTO->getResult(),
            ]);
    }
}
