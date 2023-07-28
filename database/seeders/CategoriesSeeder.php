<?php

namespace Database\Seeders;

use App\Models\Categories;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'Without category',
            ],
            [
                'name' => 'Technology',
            ],
        ];

        // Query Builder --> https://laravel.com/docs/10.x/queries
        DB::table('categories')->insert($data);
        Categories::create( [
            'name' => 'Development',
            'category_id' => 2
        ]);
    }
}
