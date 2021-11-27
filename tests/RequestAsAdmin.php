<?php


namespace Tests;
use App\Models\{Role, User, Nre};

trait RequestAsAdmin
{
    public function getAdmin()
    {
        if (User::where('name', 'Admin')->exists()) {
           return User::where('name', 'Admin')->first();
        }

        $user = User::factory()->create([
            'name' => 'Admin',
            'nre_id' => Nre::factory()->create()->id,
        ]);

        $admin = Role::create([
            'name' => 'administrator',
            'display_name' => 'Administrator ',
            'description' => 'User allowed to see the index of users',
        ]);
        $user->attachRole($admin);

        return $user;
    }

}
