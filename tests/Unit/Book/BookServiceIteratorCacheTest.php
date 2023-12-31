<?php

namespace Book;

use App\Repositories\Books\BookIndexDTO;
use App\Repositories\Books\BookRepository;
use App\Repositories\Books\Iterators\BooksIterator;
use App\Services\Books\BookServiceIteratorCache;
use App\Services\Cache\CacheService;
use PHPUnit\Framework\TestCase;

class BookServiceIteratorCacheTest extends TestCase
{
    protected BookServiceIteratorCache $bookServiceIteratorCache;
    protected CacheService $cacheService;
    protected BooksIterator $booksIterator;
    protected BookRepository $bookRepository;

    protected BookIndexDTO $bookIndexDTO;

    public function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        $this->bookIndexDTO = $this->createMock(BookIndexDTO::class);
        $this->booksIterator = $this->createMock(BooksIterator::class);
        $this->bookRepository = $this->createMock(BookRepository::class);
        $this->cacheService = $this->createMock(CacheService::class);
        $this->bookServiceIteratorCache = new BookServiceIteratorCache
        (
            $this->bookRepository,
            $this->cacheService
        );
    }

    /**
     * @throws \Exception
     */
    public function testIndexIteratorNoCacheNull(): void
    {
        $dto = $this->bookIndexDTO;
        $iterator = $this->booksIterator;
        $this->cacheService
            ->expects(self::once())
            ->method('handle')
            ->with($dto)
            ->willReturn(null);

        $this->bookRepository
            ->expects(self::once())
            ->method('getByDataIterator')
            ->with($dto)
            ->willReturn($iterator);

        $resultRepository = $this->booksIterator;

        $resultService = $this->bookServiceIteratorCache->indexIteratorNoCache($dto);
        $this->assertSame($resultRepository, $resultService);
    }

    public function testIndexIteratorNoCache(): void
    {
        $dto = $this->bookIndexDTO;
        $iterator = $this->booksIterator;
        $this->cacheService
            ->expects(self::once())
            ->method('handle')
            ->with($dto)
            ->willReturn($iterator);

        $this->bookRepository
            ->expects(self::never())
            ->method('getByDataIterator');


        $resultRepository = $this->booksIterator;

        $resultService = $this->bookServiceIteratorCache->indexIteratorNoCache($dto);
        $this->assertSame($resultRepository, $resultService);
    }

}
