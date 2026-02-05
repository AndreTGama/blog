<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        foreach (['admin', 'editor', 'moderator'] as $role) {
            Role::firstOrCreate(['name' => $role]);
        }
    }
}
