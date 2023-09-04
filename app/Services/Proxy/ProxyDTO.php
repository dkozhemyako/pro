<?php

namespace App\Services\Proxy;

class ProxyDTO implements \JsonSerializable
{
    private string $proxyUrl;
    public function __construct(
        protected string $username,
        protected string $password,
        protected string $proxyAddress,
        protected int $port,
    ) {
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getProxyAddress(): string
    {
        return $this->proxyAddress;
    }

    /**
     * @return int
     */
    public function getPort(): int
    {
        return $this->port;
    }


    public function jsonSerialize(): array
    {
        return [
            'username' => $this->username,
            'password' => $this->password,
            'proxyAddress' => $this->proxyAddress,
            'port' => $this->port,
        ];
    }

    private function getData(): void
    {
        $this->proxyUrl =  'http://' . $this->username . ':' . $this->password . '@' . $this->proxyAddress . ':' . $this->port;
    }

    /**
     * @return string
     */
    public function getProxyUrl(): string
    {
        $this->getData();
        return $this->proxyUrl;
    }


}
