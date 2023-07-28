<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            TypesUsersSeeder::class,
            CategoriesSeeder::class,
        ]);
        \App\Models\User::factory(10)->create();
        \App\Models\Posts::factory(50)->create();
        \App\Models\PostsHasCategories::factory(100)->create();
    }
}
