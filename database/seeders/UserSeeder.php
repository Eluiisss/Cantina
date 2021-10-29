<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use App\Models\{Nre, Role, User};
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{

    private $nres;
    private $roles;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->fetchRelations();

        $this->createAdmins();

        foreach (range(1, 49) as $i) {
            $this->createRandomUser();
        }
    }

    public function fetchRelations()
    {
        $this->nres = Nre::all();
        $this->roles = Role::all();
    }

    public function createAdmins()
    {
        $eluis = User::create([
            'name' => 'José Luis Nicolás',
            'nre_id' => $this->nres->firstWhere('nre', '1889417')->id,
            'email' => 'joseluisnicolasnr@gmail.com',
            'email_verified_at' => now(),
            'phone' => '656238544',
            'password' => bcrypt('Eluiisss'),
            'class' => '2ºDAW',
            'banned' => 0,
            'remember_token' => Str::random(10),
            'created_at' => now(),
        ]);

        $manuel = User::create([
            'name' => 'Manuel Martínez',
            'nre_id' => $this->nres->firstWhere('nre', '1928721')->id,
            'email' => 'manuelmcw@gmail.com',
            'email_verified_at' => now(),
            'phone' => '656805944',
            'password' => bcrypt('M4NUK-W'),
            'class' => '2ºDAW',
            'banned' => 0,
            'remember_token' => Str::random(10),
            'created_at' => now(),
        ]);

        $eduardo = User::create([
            'name' => 'Eduardo Noguera',
            'nre_id' => $this->nres->firstWhere('nre', '1642291')->id,
            'email' => 'eduardo.nogueraga@gmail.com',
            'email_verified_at' => now(),
            'phone' => '656123455',
            'password' => bcrypt('eduardonogueraga'),
            'class' => '2ºDAW',
            'banned' => 0,
            'remember_token' => Str::random(10),
            'created_at' => now(),
        ]);

        $eluis->attachRole($this->roles->firstWhere('name', 'administrator')->id);
        $manuel->attachRole($this->roles->firstWhere('name', 'administrator')->id);
        $eduardo->attachRole($this->roles->firstWhere('name', 'administrator')->id);
    }

    public function createRandomUser()
    {
        $user = User::factory()->create([
            'nre_id' => $this->nres->random()->id,
        ]);

        $user->attachRole($this->roles->firstWhere('name', 'user')->id);
    }
}
