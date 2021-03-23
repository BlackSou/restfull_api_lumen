<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'first_name' => 'Lumen',
            'last_name' => 'Laravel',
            'email' => 'lumen@first.test',
            'phone' => '+3800000000',
            'password' => Hash::make('qwer1234'),
            'api_token' => '',
        ]);
        $this->call([
            CompanySeeder::class
        ]);
    }
}
