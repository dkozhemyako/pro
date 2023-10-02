<?php

namespace Books;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Book;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;


class BookDestroyTest extends TestCase
{
    private $book;

    public function setUp(): void
    {
        parent::setUp();
        $this->book = Book::query()->first();
    }


    public function testSuccessfulDelete(): void
    {
        $data =
            [
                'id' => $this->book->id,
            ];

        $this->assertDatabaseHas('books', [
            'id' => $data['id'],
        ]);

        $response = $this->deleteJson('http://pro.loc/api/books/' . $this->book->id, $data);

        $response->assertStatus(204);

        $this->assertDatabaseMissing('books', [
            'id' => $data['id'],
        ]);
    }

}
