<?php

namespace Database\Seeders;


use App\Models\Account;
use Illuminate\Database\Seeder;



class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *  php artisan db:seed --class=AccountSeeder 
     * @return void
     */
    public function run()
    {
        Account::factory()->count(3)->create();
    }
}
