<?php

namespace App\Console\Commands;

use Database\Seeders\ItemGroupSeeder;
use Illuminate\Console\Command;

class SeedItem extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seed:item';

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
        $this->call(ItemGroupSeeder::class);
    }
}
