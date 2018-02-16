<?php

use Illuminate\Database\Seeder;
use Faker\Factory;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $faker = Factory::create();

        // User::truncate();

        User::create([
            'name' => "Admin Superadmin",
            'email' => "slidemonster@topdogimsolutions.com",
            'password' => bcrypt('01admin01'),
            'api_token' => str_random(60),
            'role' => 1
        ]);

        // User::create([
        //     'name' => "Dexter Bengil",
        //     'email' => "dexterb2992@gmail.com",
        //     'password' => bcrypt('dexter'),
        //     'api_token' => str_random(60)
        // ]);
    }
}
