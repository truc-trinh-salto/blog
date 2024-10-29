<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TestArtisan extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test-artisan {id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $id = $this->argument('id');
        $this->info("Test Artisan ".$id);
    }
}
