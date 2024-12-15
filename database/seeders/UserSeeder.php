<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Now, let's seed the users
        $user_seed = [
            [
                'custname' => 'MUHAMMAD AIMAN SYAZWAN BIN MOHD ZALIZAMAN',
                'custpassword' => bcrypt('696969'),
                'custphone' => '0196081247',
                'custemail' => 'aimansyazwan300@gmail.com',
                'usertype' => 'admin',
                'custaddress' => 'Address 1'
            ],
            [
                'custname' => 'ADMIN',
                'custpassword' => bcrypt('12345'),
                'custphone' => '0123456789',
                'custemail' => 'admin@gmail.com',
                'usertype' => 'admin',
                'custaddress' => 'Address 2'
            ],
            [
                'custname' => 'ISMAIL AHMAD KANABAWI',
                'custpassword' => bcrypt('okay'),
                'custphone' => '0146231245',
                'custemail' => 'kanabawi@gmail.com',
                'usertype' => 'user',
                'custaddress' => 'Address 3'
            ],
            [
                'custname' => 'CUSTOMER',
                'custpassword' => bcrypt('12345'),
                'custphone' => '0198765432',
                'custemail' => 'customer@gmail.com',
                'usertype' => 'user',
                'custaddress' => 'Address 4'
            ],
        ];

        // Seed users
        foreach ($user_seed as $user) {
            User::create($user);
        }
    }
}
