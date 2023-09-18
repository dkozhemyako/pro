<?php

namespace App\Repositories\Books;

class AuthorBookCreateDTO
{
    public function __construct(
        protected int $authorId,
        protected int $bookId,
    ) {
    }

    /**
     * @return int
     */
    public function getAuthorId(): int
    {
        return $this->authorId;
    }

    /**
     * @return int
     */
    public function getBookId(): int
    {
        return $this->bookId;
    }

}
