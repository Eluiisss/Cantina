<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    protected $users;

    public function run()
    {
        $this->users = User::inRandomOrder()->pluck('id');

        foreach (range(0,50) as $i){
            $articles = Article::inRandomOrder()->take(rand(1,2))->pluck('id');
            $this->createRandomOrders($articles);
        }
    }

    public function createRandomOrders($articles)
    {
        $date = now()->subDays(rand(0,60));

        $order = Order::factory()->create([
            'user_id' => $this->users->random(),
            'created_at' => $date,
        ]);
        $order->articles()
            ->attach($articles, [
            'quantity' => rand(1,2),
            'created_at' => $date,
            'updated_at' => $date
            ]);
    }
}
