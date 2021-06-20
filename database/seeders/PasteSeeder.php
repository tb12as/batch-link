<?php

namespace Database\Seeders;

use App\Models\Link;
use App\Models\Paste;
use Illuminate\Database\Seeder;

class PasteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Paste::factory(20)
            // ->has(Link::factory()->count(5))
            ->hasLinks(5)
            ->create();
    }
}
