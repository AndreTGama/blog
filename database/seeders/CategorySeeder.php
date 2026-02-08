<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['name' => 'Technology'],
            ['name' => 'Health'],
            ['name' => 'Travel'],
            ['name' => 'Food'],
            ['name' => 'Education'],
        ];
        
        foreach ($data as $item) {
            \App\Models\Category::create($item);
        }
    }
}
