<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use App\Models\Book;
use Illuminate\Queue\Attributes\WithoutRelations;
use Illuminate\Support\Facades\Log;

class ProcessPodcast implements ShouldQueue, ShouldBeUnique
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        //Queue relationships
        #[WithoutRelations]
        public Book $book)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Log::info('Dispatch of Process podcast '.$this->book->book_id);
        $this->fail();
        Log::info('Dispatch of Process podcast '.$this->book->book_id);
    }

    //Queue unique ID for the job

    public function uniqueId(): string
    {
        return $this->book->book_id;
    }
}
