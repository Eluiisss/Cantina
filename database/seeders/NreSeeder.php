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
        Nre::factory()->create(['nre' => '1889417']);
        Nre::factory()->create(['nre' => '1928721']);
        Nre::factory()->create(['nre' => '1642291']);

        Nre::factory()->times(50)->create();
    }
}
