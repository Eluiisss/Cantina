<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $this->truncateTables(['articles', 'nutrition', 'categories', 'nres', 'users', 'orders', 'article_order']);

        $this->call(CategorySeeder::class);
        $this->call(ArticleSeeder::class);
        $this->call(NreSeeder::class);
        $this->call(LaratrustSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(OrderSeeder::class);
    }

    public function truncateTables(array $tables)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        foreach ($tables as $table) {
            DB::table($table)->truncate();
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
