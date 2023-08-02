<?php

namespace App\Services\User;

use App\Repositories\Users\Iterators\UserIterator;
use Laravel\Passport\PersonalAccessTokenResult;

class LoginDTO
{
    protected UserIterator $user;
    protected PersonalAccessTokenResult $token;

    public function __construct
    (
        protected string $email,
        protected string $password,
        protected string $ip,

    ) {
    }

    /**
     * @return PersonalAccessTokenResult
     */
    public function getToken(): PersonalAccessTokenResult
    {
        return $this->token;
    }

    /**
     * @param PersonalAccessTokenResult $token
     */
    public function setToken(PersonalAccessTokenResult $token): void
    {
        $this->token = $token;
    }

    /**
     * @return UserIterator
     */
    public function getUser(): UserIterator
    {
        return $this->user;
    }

    /**
     * @param UserIterator $user
     */
    public function setUser(UserIterator $user): void
    {
        $this->user = $user;
    }

    /**
     * @return string
     */
    public function getIp(): string
    {
        return $this->ip;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setError()
    {
    }

}
