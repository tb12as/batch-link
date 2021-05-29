<?php

namespace App\Console\Commands;

use App\Models\Link;
use App\Models\Paste;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DeleteAll extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clear:database';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'wipe all data';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        DB::statement("SET foreign_key_checks=0");
        Paste::truncate();
        Link::truncate();
        DB::statement("SET foreign_key_checks=1");
    }
}
