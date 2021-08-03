<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
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
        $user = User::updateOrCreate([
            'name' => 'developer',
            'phone' => '+855123456789',
            'email' => 'dev@dev.com',
            'password' => Hash::make('12345678'),
            'is_phone_verified' => Carbon::now()->toDateTimeString()
        ]);

        $user->contact()->firstOrCreate([
            'first_name' => 'devlop',
            'last_name'  => 'per',
            'phone' => '+855123456789',
            'account_id' => 1
        ]);
    }
}
