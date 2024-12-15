<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role_seed = [
            ['roleid' => '1', 'rolename' => 'Admin'],
            ['roleid' => '2', 'rolename' => 'Customer'],
        ];

        foreach ($role_seed as $role_seed) {
            Role::firstOrCreate($role_seed);
        }
    }
}
