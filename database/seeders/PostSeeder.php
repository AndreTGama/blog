<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Post::factory()->count(10)->afterCreating(function ($post) {
            $categories = \App\Models\Category::inRandomOrder()->take(rand(1, 3))->pluck('id');
            $post->categories()->attach($categories);
        })->create();
    }
}
