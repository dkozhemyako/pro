<?php

namespace App\Services\Proxy;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use JsonSerializable;

class GetMyIpService
{
    public function __construct
    (
        protected Client $client,
        protected WebShareService $webShareService,
    ) {
    }

    public function handle(): string
    {
        $proxyCount = count(Redis::lrange('proxy_list', 0, 10));
        if ($proxyCount < 5) {
            Redis::delete('proxy_list');
            $this->webShareService->refreshProxy();
        }

        $proxy = json_decode(Redis::lpop('proxy_list'), true);
        $userData = $proxy['username'] . ':' . $proxy['password'];
        $startTime = microtime(true);
        $result = $this->client->get(
            'https://api.myip.com',
            [
                'proxy' => 'http://' . $userData . '@' . $proxy['proxy_address'] . ':' . $proxy['port'],
            ]
        );
        $time = microtime(true) - $startTime;
        if ($time < 1) {
            Redis::rpush('proxy_list', json_encode($proxy));
        }

        return $result->getBody()->getContents();
    }

}


