<?php

namespace App\Console\Commands;

use App\Repositories\Books\BookRepository;
use App\Repositories\Books\CountBookDTO;
use App\Services\Books\BookCountCommentsStorage;
use App\Services\Books\BookCountViewsStorage;
use Illuminate\Console\Command;

class StoreCountBookViewsAndComments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:store-count-book-views-and-comments';

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
        protected BookCountViewsStorage $viewsStorage,
        protected BookCountCommentsStorage $commentsStorage,
        protected BookRepository $repository,
    )
    {
        parent::__construct();
    }

    public function handle()
    {
        $views = json_decode($this->viewsStorage->get());
        $comments = json_decode($this->commentsStorage->get());


        foreach ($views as $key => $value){
            $dto = new CountBookDTO(
              $key,
              $value,
            );
            $this->repository->storeViewsHour($dto);
        }


        foreach ($comments as $key => $value){
            $dto = new CountBookDTO(
                $key,
                $value,
            );
            $this->repository->storeComentsHour($dto);
        }

    }
}
