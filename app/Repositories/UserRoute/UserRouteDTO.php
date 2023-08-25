<?php

namespace App\Repositories\UserRoute;

use App\Enums\MethodEnum;

class UserRouteDTO
{
    public function __construct
    (
        protected int $userId,
        protected MethodEnum $methodEnum,
        protected string $route,
    ) {
    }

    /**
     * @param MethodEnum $methodEnum
     */
    public function setMethodEnum(MethodEnum $methodEnum): void
    {
        $this->methodEnum = $methodEnum;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @return MethodEnum
     */
    public function getMethodEnum(): MethodEnum
    {
        return $this->methodEnum;
    }

    /**
     * @return string
     */
    public function getRoute(): string
    {
        return $this->route;
    }


}
