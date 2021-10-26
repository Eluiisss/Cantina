<?php

namespace Database\Seeders;

use App\Models\Nre;
use Illuminate\Database\Seeder;

class NreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Nre::factory()->times(30)->create();
    }
}
