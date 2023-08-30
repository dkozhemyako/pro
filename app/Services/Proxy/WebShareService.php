<?php

namespace App\Services\Proxy;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Redis;


class WebShareService
{
    public function __construct
    (
        protected Client $client,
        protected ProxyStorage $proxyStorage,
    ) {
    }

    public function getProxy()
    {
        $result = $this->client->
        get(
            'https://proxy.webshare.io/api/v2/proxy/list',
            [
                'query' => [
                    'mode' => 'direct',
                    'page' => 1,
                    'page_size' => 25,
                ],
                'headers' =>
                    [
                        'Authorization' => 'Token ' . config('proxy.api_key'),
                    ],

            ]
        );

        $content = $result->getBody()->getContents();

        foreach (json_decode($content)->results as $obj) {
            $proxy = [
                'username' => $obj->username,
                'password' => $obj->password,
                'proxyAddress' => $obj->proxy_address,
                'port' => $obj->port,
            ];
            $this->proxyStorage->rpush(new ProxyDTO(...$proxy));
        }
    }

    public function refreshProxy()
    {
        $result = $this->client->
        post(
            'https://proxy.webshare.io/api/v2/proxy/list/refresh/',
            [
                'headers' =>
                    [
                        'Authorization' => 'Token ' . config('proxy.api_key'),
                    ],

            ]
        );

        $content = $result->getBody()->getContents();

        foreach (json_decode($content)->results as $obj) {
            $proxy = [
                'username' => $obj->username,
                'password' => $obj->password,
                'proxyAddress' => $obj->proxy_address,
                'port' => $obj->port,
            ];
            Redis::rpush('proxy_list', json_encode($proxy));
        }
    }

}


