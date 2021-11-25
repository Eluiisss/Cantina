<?php


namespace Admin\OrdersTest;


use App\Models\Article;
use App\Models\Category;
use App\Models\Nre;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Str;

trait BaseOrdersTest
{
    protected $role;

    private function createUser($name = null, $email = null)
    {
        $nre = Nre::factory()->create();
        $user = User::factory()->create([
            'nre_id' => $nre->id,
            'class' => '2ºDAM',
            'phone' => '656238544',
        ]);

        if ($name){
            $user->update([
                'name' => $name,
                'email' => $email ?? (Str::snake($name).'@mail.com'),
            ]);
        }

        $user->attachRole($this->role);
        return $user;
    }

    private function createArticles(): void
    {
        $category = Category::factory()->create();
        Article::factory()->times(20)->create([
            'category_id' => $category->id
        ]);
    }

    private function createUserRole(): void
    {
        $this->role = Role::create([
            'name' => 'user',
            'display_name' => 'User ',
            'description' => 'User is not allowed to manage and edit other users',
        ]);
    }
}
