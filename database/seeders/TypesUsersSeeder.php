<?php

namespace Database\Seeders;

use App\Models\TypesUsers;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypesUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'Admin',
            ],
            [
                'name' => 'Moderator',
            ],
            [
                'name' => 'User',
            ],
        ];

        // Query Builder --> https://laravel.com/docs/10.x/queries
        DB::table('types_users')->insert($data);
    }
}
