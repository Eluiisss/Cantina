<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use App\Models\{Nre, User};
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{

    private $nres;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->fetchRelations();

        $this->createAdmin();

        foreach (range(1, 49) as $i) {
            $this->createRandomUser();
        }
    }

    public function fetchRelations()
    {
        $this->nres = Nre::all();
    }

    public function createAdmin()
    {
        User::create([
            'name' => 'José Luis Nicolás',
            'nre_id' => $this->nres->firstWhere('nre', '1889417')->id,
            'email' => 'joseluisnicolasnr@gmail.com',
            'email_verified_at' => now(),
            'phone' => '656238544',
            'password' => bcrypt('eluiisss'),
            'role' => 'user',
            'class' => '2ºDAW',
            'banned' => 0,
            'remember_token' => Str::random(10),
            'created_at' => now(),
        ]);
    }

    public function createRandomUser()
    {
        User::factory()->create([
            'nre_id' => $this->nres->random()->id,
        ]);
    }
}
