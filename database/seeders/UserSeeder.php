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

        foreach (range(1, 10) as $i) {
            $this->createRandomEmployee();
        }

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
        $adminNre = $this->nres->firstWhere('nre', '1889417');
        $eluis = User::create([
            'name' => 'José Luis Nicolás',
            'nre_id' => $adminNre->id,
            'email' => 'joseluisnicolasnr@gmail.com',
            'email_verified_at' => now(),
            'phone' => '656238544',
            'password' => bcrypt('Eluiisss'),
            'class' => '2ºDAW',
            'banned' => 1,
            'ban_strikes' => 0,
            'remember_token' => Str::random(10),
            'created_at' => now(),
        ]);
        $adminNre->update([
            'user_id' => $eluis->id,
            'updated_at' => now(),
        ]);

        $adminNre = $this->nres->firstWhere('nre', '1928721');
        $manuel = User::create([
            'name' => 'Manuel Martínez',
            'nre_id' => $adminNre->id,
            'email' => 'manuelmcw@gmail.com',
            'email_verified_at' => now(),
            'phone' => '656805944',
            'password' => bcrypt('M4NUK-W'),
            'class' => '2ºDAW',
            'banned' => 1,
            'ban_strikes' => 0,
            'remember_token' => Str::random(10),
            'created_at' => now(),
        ]);
        $adminNre->update([
            'user_id' => $manuel->id,
            'updated_at' => now(),
        ]);

        $adminNre = $this->nres->firstWhere('nre', '1642291');
        $eduardo = User::create([
            'name' => 'Eduardo Noguera',
            'nre_id' => $adminNre->id,
            'email' => 'eduardo.nogueraga@gmail.com',
            'email_verified_at' => now(),
            'phone' => '656123455',
            'password' => bcrypt('eduardonogueraga'),
            'class' => '2ºDAW',
            'banned' => 1,
            'ban_strikes' => 0,
            'remember_token' => Str::random(10),
            'created_at' => now(),
        ]);
        $adminNre->update([
            'user_id' => $eduardo->id,
            'updated_at' => now(),
        ]);

        $eluis->attachRole($this->roles->firstWhere('name', 'administrator')->id);
        $manuel->attachRole($this->roles->firstWhere('name', 'administrator')->id);
        $eduardo->attachRole($this->roles->firstWhere('name', 'administrator')->id);
    }

    public function createRandomUser()
    {
        $userNre = $this->nres->where('user_id', null)->random();
        $user = User::factory()->create([
            'nre_id' => $userNre->id,
            'banned' => rand(0,1),
        ]);

        $userNre->update([
            'user_id' => $user->id,
            'updated_at' => now(),
        ]);
        $user->attachRole($this->roles->firstWhere('name', 'user')->id);
    }
    public function createRandomEmployee()
    {
        $userNre = $this->nres->where('user_id', null)->random();
        $user = User::factory()->create([
            'nre_id' => $userNre->id,
            'banned' => rand(0,1),
        ]);

        $userNre->update([
            'user_id' => $user->id,
            'updated_at' => now(),
        ]);
        $user->attachRole($this->roles->firstWhere('name', 'employee')->id);
    }

}
