<?php

namespace Books;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;


class BookIndexTest extends TestCase
{


    public function testSuccessfulIndexDate(): void
    {
        $data =
            [
                'startDate' => '2022-01-01',
                'endDate' => '2024-08-20',
            ];
        $response = $this->getJson(
            'http://pro.loc/api/books?' . 'startDate=' . $data['startDate'] . '&endDate=' . $data['endDate']
        );

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    [
                        'id',
                        'name',
                        'year',
                        'lang',
                        'pages',
                        'category' => [
                            'id',
                            'name',
                        ],
                    ]
                ],
            ]);
    }

    /**
     * @dataProvider dataFailedIndexDate
     * @param array $data
     * @param string $errorMsg
     * @param string $field
     * @return void
     */

    public function testFailedIndexDate(array $data, string $errorMsg, string $field): void
    {
        if (array_key_exists('startDate', $data) === true && array_key_exists('endDate', $data) === true) {
            $response = $this->getJson(
                'http://pro.loc/api/books?' . 'startDate=' . $data['startDate'] . '&endDate=' . $data['endDate']
            );
        }
        if (array_key_exists('startDate', $data) === false) {
            $response = $this->getJson('http://pro.loc/api/books?' . 'endDate=' . $data['endDate']);
        }
        if (array_key_exists('endDate', $data) === false) {
            $response = $this->getJson('http://pro.loc/api/books?' . 'startDate=' . $data['startDate']);
        }


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

    public static function dataFailedIndexDate(): array
    {
        return [
            'startDate: required' =>
                [
                    [
                        'endDate' => '2023-01-01',
                    ],
                    'The start date field is required.',
                    'startDate'
                ],
            'endDate: required' =>
                [
                    [
                        'startDate' => '2022-01-01',
                    ],
                    'The end date field is required.',
                    'endDate'
                ],
            'startDate: before:endDate' =>
                [
                    [
                        'startDate' => '2023-01-01',
                        'endDate' => '2022-01-01',
                    ],
                    'The start date field must be a date before end date.',
                    'startDate'
                ],
            'endDate: after:startDate' =>
                [
                    [
                        'startDate' => '2023-01-01',
                        'endDate' => '2022-01-01',
                    ],
                    'The end date field must be a date after start date.',
                    'endDate'
                ],
            'startDate: valid Date' =>
                [
                    [
                        'startDate' => 2023 - 01 - 01,
                        'endDate' => '2022-01-01',
                    ],
                    'The start date field must be a valid date.',
                    'startDate'
                ],
            'endDate: valid Date' =>
                [
                    [
                        'startDate' => '2023-01-01',
                        'endDate' => 2022 - 01 - 01,
                    ],
                    'The end date field must be a valid date.',
                    'endDate'
                ],

        ];
    }

    public function testSuccessfulIndexYear(): void
    {
        $data =
            [
                'startDate' => '2022-01-01',
                'endDate' => '2024-08-20',
                'year' => 1970,
            ];
        $response = $this->getJson(
            'http://pro.loc/api/books?' . 'startDate=' . $data['startDate'] . '&endDate=' . $data['endDate'] . '&year=' . $data['year']
        );

        $response
            ->assertStatus(200)
            ->assertJson(fn(AssertableJson $json) => $json
                ->where('data.0.year', $data['year'])
            )
            ->assertJsonStructure([
                'data' => [
                    [
                        'id',
                        'name',
                        'year',
                        'lang',
                        'pages',
                        'category' => [
                            'id',
                            'name',
                        ],
                    ]
                ],
            ]);
    }

    /**
     * @dataProvider dataFailedIndexYear
     * @param array $data
     * @param string $errorMsg
     * @param string $field
     * @return void
     */

    public function testFailedIndexYear(array $data, string $errorMsg, string $field): void
    {
        $response = $this->getJson(
            'http://pro.loc/api/books?' . 'startDate=' . $data['startDate'] . '&endDate=' . $data['endDate'] . '&year=' . $data['year']
        );

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

    public static function dataFailedIndexYear(): array
    {
        return [
            'year: integer' =>
                [
                    [
                        'startDate' => '2022-01-01',
                        'endDate' => '2024-01-01',
                        'year' => 'string',
                    ],
                    'The year field must be an integer.',
                    'year'
                ],
            'year: min' =>
                [
                    [
                        'startDate' => '2022-01-01',
                        'endDate' => '2024-01-01',
                        'year' => 1969,
                    ],
                    'The year field must be at least 1970.',
                    'year'
                ],
            'year: max' =>
                [
                    [
                        'startDate' => '2022-01-01',
                        'endDate' => '2024-01-01',
                        'year' => 2100,
                    ],
                    'The year field must be a date before or equal to today.',
                    'year'
                ],
            'year: date_format:Y' =>
                [
                    [
                        'startDate' => '2022-01-01',
                        'endDate' => '2024-01-01',
                        'year' => time(),
                    ],
                    'The year field must match the format Y.',
                    'year'
                ],


        ];
    }

    public function testSuccessfulIndexLang(): void
    {
        $data =
            [
                'startDate' => '2022-01-01',
                'endDate' => '2024-08-20',
                'lang' => 'ua',
            ];
        $response = $this->getJson(
            'http://pro.loc/api/books?' . 'startDate=' . $data['startDate'] . '&endDate=' . $data['endDate'] . '&lang=' . $data['lang']
        );

        $response
            ->assertStatus(200)
            ->assertJson(fn(AssertableJson $json) => $json
                ->where('data.0.lang', $data['lang'])
            )
            ->assertJsonStructure([
                'data' => [
                    [
                        'id',
                        'name',
                        'year',
                        'lang',
                        'pages',
                        'category' => [
                            'id',
                            'name',
                        ],
                    ]
                ],
            ]);
    }

    /**
     * @dataProvider dataFailedIndexLang
     * @param array $data
     * @param string $errorMsg
     * @param string $field
     * @return void
     */

    public function testFailedIndexLang(array $data, string $errorMsg, string $field): void
    {
        $response = $this->getJson(
            'http://pro.loc/api/books?' . 'startDate=' . $data['startDate'] . '&endDate=' . $data['endDate'] . '&lang=' . $data['lang']
        );

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

    public static function dataFailedIndexLang(): array
    {
        return [
            'lang: Rule::in' =>
                [
                    [
                        'startDate' => '2022-01-01',
                        'endDate' => '2024-01-01',
                        'lang' => 'au',
                    ],
                    'The selected lang is invalid.',
                    'lang'
                ],
        ];
    }

    //
    public function testSuccessfulIndexYearLang(): void
    {
        $data =
            [
                'startDate' => '2022-01-01',
                'endDate' => '2024-08-20',
                'year' => 1970,
                'lang' => 'ua',
            ];
        $response = $this->getJson(
            'http://pro.loc/api/books?' . 'startDate=' . $data['startDate'] . '&endDate=' . $data['endDate'] . '&year=' . $data['year'] . '&lang=' . $data['lang']
        );

        $response
            ->assertStatus(200)
            ->assertJson(fn(AssertableJson $json) => $json
                ->where('data.0.year', $data['year'])
                ->where('data.0.lang', $data['lang'])
            )
            ->assertJsonStructure([
                'data' => [
                    [
                        'id',
                        'name',
                        'year',
                        'lang',
                        'pages',
                        'category' => [
                            'id',
                            'name',
                        ],
                    ]
                ],
            ]);
    }

    /**
     * @dataProvider dataFailedIndexYearLang
     * @param array $data
     * @param string $errorMsg
     * @param string $field
     * @return void
     */

    public function testFailedIndexYearLang(array $data, string $errorMsg, string $field): void
    {
        $response = $this->getJson(
            'http://pro.loc/api/books?' . 'startDate=' . $data['startDate'] . '&endDate=' . $data['endDate'] . '&year=' . $data['year'] . '&lang=' . $data['lang']
        );

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

    public static function dataFailedIndexYearLang(): array
    {
        return [
            'year: integer' =>
                [
                    [
                        'startDate' => '2022-01-01',
                        'endDate' => '2024-01-01',
                        'year' => 'string',
                        'lang' => 'ua'
                    ],
                    'The year field must be an integer.',
                    'year'
                ],
            'year: min' =>
                [
                    [
                        'startDate' => '2022-01-01',
                        'endDate' => '2024-01-01',
                        'year' => 1969,
                        'lang' => 'ua'
                    ],
                    'The year field must be at least 1970.',
                    'year'
                ],
            'year: max' =>
                [
                    [
                        'startDate' => '2022-01-01',
                        'endDate' => '2024-01-01',
                        'year' => 2100,
                        'lang' => 'ua'
                    ],
                    'The year field must be a date before or equal to today.',
                    'year'
                ],
            'year: date_format:Y' =>
                [
                    [
                        'startDate' => '2022-01-01',
                        'endDate' => '2024-01-01',
                        'year' => time(),
                        'lang' => 'ua'
                    ],
                    'The year field must match the format Y.',
                    'year'
                ],
            'lang: Rule::in' =>
                [
                    [
                        'startDate' => '2022-01-01',
                        'endDate' => '2024-01-01',
                        'lang' => 'au',
                        'year' => 1970
                    ],
                    'The selected lang is invalid.',
                    'lang'
                ],


        ];
    }

}
