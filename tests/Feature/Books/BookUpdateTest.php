<?php

namespace Books;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Book;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;


class BookUpdateTest extends TestCase
{
    private $book;

    public function setUp(): void
    {
        parent::setUp();
        $this->book = Book::query()->first();
    }

    /**
     * Need change for every test, length = 100
     */
    private const UNIQUE_NAME = '0dfXsggnoNRyGudmIZSDvZBrNDEcsXDovrfzvqpdMMyrxuuBOpZjEdqIwkOBSWmlJpcObjcYihfhFHOSjmXbkOtQZYAUptixqpTi';

    public function testSuccessfulUpdate(): void
    {
        $data =
            [
                'id' => $this->book->id,
                'name' => self::UNIQUE_NAME,
                'year' => 1970,
                'lang' => 'en',
                'pages' => 55000,
            ];
        $response = $this->putJson('http://pro.loc/api/books/' . $this->book->id, $data);

        $response
            ->assertStatus(200)
            ->assertJson(fn(AssertableJson $json) => $json
                ->where('data.name', $data['name'])
                ->where('data.year', $data['year'])
                ->where('data.lang', $data['lang'])
                ->where('data.pages', $data['pages'])
            )
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'year',
                    'lang',
                    'pages',
                    'category' => [
                        'id',
                        'name',
                    ],
                ],
            ]);
        $this->assertDatabaseHas('books', [
            'name' => self::UNIQUE_NAME,
        ]);
    }

    /**
     * @dataProvider dataFailedUpdate
     * @param array $data
     * @param string $errorMsg
     * @param string $field
     * @param int $bookID
     * @return void
     */

    public function testFailedUpdate(array $data, string $errorMsg, string $field): void
    {
        $response = $this->putJson('http://pro.loc/api/books/' . $this->book->id, $data);

        $response->assertStatus(422)
            ->assertJson(fn(AssertableJson $json) => $json
                ->where('errors.' . $field . '.0', $errorMsg)
                ->etc()
            )
            ->assertJsonStructure([
                'message',
                'errors' => [
                    $field
                ]
            ]);
    }

    public static function dataFailedUpdate(): array
    {
        return [
            'Name: max length' =>
                [
                    [
                        'name' => 'LdUuDsgvaiNReGudmIZSDfZBrNDEHsXDovrfzvqpdMMyrxuuBOpZjEdqIwkOBSWmlJpcObjcYihfhFHOSjmXbkOtQZYAUptixqpTi',
                        'year' => '2023',
                        'lang' => 'en',
                        'pages' => '100',
                    ],
                    'The name field must be between 1 and 100 characters.',
                    'name'
                ],
            'Name: required' =>
                [
                    [
                        'year' => '2023',
                        'lang' => 'en',
                        'pages' => '100',

                    ],
                    'The name field is required.',
                    'name'
                ],
            'Name: unique' =>
                [
                    [
                        'name' => self::UNIQUE_NAME,
                        'year' => '2023',
                        'lang' => 'en',
                        'pages' => '100',
                    ],
                    'The name has already been taken.',
                    'name'
                ],
            'Name: string' =>
                [
                    [
                        'name' => 123,
                        'year' => '2023',
                        'lang' => 'en',
                        'pages' => '100',
                    ],
                    'The name field must be a string.',
                    'name'
                ],
            'Year: required' =>
                [
                    [
                        'name' => 'NewNameBook',
                        'lang' => 'en',
                        'pages' => '100',
                    ],
                    'The year field is required.',
                    'year'
                ],
            'Year: integer' =>
                [
                    [
                        'name' => 'NewNameBook',
                        'year' => 'String',
                        'lang' => 'en',
                        'pages' => '100',
                    ],
                    'The year field must be an integer.',
                    'year'
                ],
            'Year: date_format' =>
                [
                    [
                        'name' => 'NewNameBook',
                        'year' => 1012023,
                        'lang' => 'en',
                        'pages' => '100',
                    ],
                    'The year field must match the format Y.',
                    'year'
                ],

            'Year: min' =>
                [
                    [
                        'name' => 'NewNameBook',
                        'year' => '1969',
                        'lang' => 'en',
                        'pages' => '100',
                    ],
                    'The year field must be at least 1970.',
                    'year'
                ],
            'Year: before_or_equal' =>
                [
                    [
                        'name' => 'NewNameBook',
                        'year' => '2024',
                        'lang' => 'en',
                        'pages' => '100',
                    ],
                    'The year field must be a date before or equal to today.',
                    'year'
                ],
            'lang: required' =>
                [
                    [
                        'name' => 'NewNameBook',
                        'year' => '2023',
                        'pages' => '100',
                    ],
                    'The lang field is required.',
                    'lang'
                ],
            'lang: Rule::in' =>
                [
                    [
                        'name' => 'NewNameBook',
                        'lang' => 'me',
                        'year' => '2023',
                        'pages' => '100',
                    ],
                    'The selected lang is invalid.',
                    'lang'
                ],
            'pages: required' =>
                [
                    [
                        'name' => 'NewNameBook',
                        'lang' => 'ua',
                        'year' => '2023',
                    ],
                    'The pages field is required.',
                    'pages'
                ],
            'pages: min' =>
                [
                    [
                        'name' => 'NewNameBook',
                        'lang' => 'ua',
                        'year' => '2023',
                        'pages' => '9',
                    ],
                    'The pages field must be between 10 and 55000.',
                    'pages'
                ],
            'pages: max' =>
                [
                    [
                        'name' => 'NewNameBook',
                        'lang' => 'ua',
                        'year' => '2023',
                        'pages' => '55001',
                    ],
                    'The pages field must be between 10 and 55000.',
                    'pages'
                ],
            'pages: integer' =>
                [
                    [
                        'name' => 'NewNameBook',
                        'lang' => 'ua',
                        'year' => '2023',
                        'pages' => 'asddsdasdasd',
                    ],
                    'The pages field must be an integer.',
                    'pages'
                ],
        ];
    }
}
