<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Company::create([
            'user_id' => '1',
            'title' => 'Laravel 1',
            'phone' => '11-11-11',
            'description' => 'Company 1',
        ]);
    }
}
