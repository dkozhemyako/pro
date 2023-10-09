<?php

namespace App\Console\Commands;

use App\Http\Resources\Book\BookResource;
use App\Repositories\Books\BookRepository;
use App\Repositories\Books\Iterators\BookIterator;
use Bschmitt\Amqp\Facades\Amqp;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

class FillOldBookDataCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fill-old-book-data-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function __construct(
        protected BookRepository $repository,
    )
    {
        parent::__construct();
    }

    private const  BOOK_REPLACE_KEY = 'book-replace-key';
    private const REPLACE_LIMIT = 100;

    public const QUEUE_NAME = 'replace-key';

    /**
     * @throws \Exception
     */
    public function handle()
    {
            while(true){
                $lastId = (int)Redis::get(self::BOOK_REPLACE_KEY);
                $data = $this->repository->getByDataTelegram($lastId, self::REPLACE_LIMIT);
                $books = BookResource::collection($data->getIterator()->getArrayCopy());
                /** @var BookIterator $book */
                foreach ($books as $book) {
                    Amqp::publish(self::QUEUE_NAME, json_encode($book), [
                        'queue' => self::QUEUE_NAME
                    ]);
                    Redis::set(self::BOOK_REPLACE_KEY, $book->getId());
                }

            }
    }

}
