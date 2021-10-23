<?php

namespace Database\Seeders;

use App\Models\UserType;
use Illuminate\Database\Seeder;

class UserTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserType::create([
            'typeName' => 'Admin'
        ]);
        UserType::create([
            'typeName' => 'Client'
        ]);
        UserType::create([
            'typeName' => 'Worker'
        ]);
    }
}
