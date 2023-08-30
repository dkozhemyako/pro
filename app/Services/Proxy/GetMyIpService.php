<?php

namespace App\Services\Proxy;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;


class GetMyIpService
{
    private const MIN_EXECUTION_TIME = 1;
    private const MAX_COUNT_PROXY_IN_LIST = 5;

    public function __construct
    (
        protected Client $client,
        protected WebShareService $webShareService,
        protected ProxyStorage $proxyStorage,
        protected CheckTimeService $checkTimeService,
    ) {
    }

    public function handle(): string
    {
        if ($this->proxyStorage->llen() < self::MAX_COUNT_PROXY_IN_LIST) {
            $this->proxyStorage->delete();
            $this->webShareService->refreshProxy();
        }

        $proxy = $this->proxyStorage->lpop();
        $this->checkTimeService->setStartTime();
        $result = $this->client->get(
            'https://api.myip.com',
            [
                'proxy' => $proxy->getProxyUrl(),
            ]
        );

        $this->checkTimeService->setEndTime();

        if ($this->checkTimeService->getDifTime() < self::MIN_EXECUTION_TIME) {
            $this->proxyStorage->rpush($proxy);
        }

        return $result->getBody()->getContents();
    }

}


