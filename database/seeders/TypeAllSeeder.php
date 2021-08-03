<?php

namespace Database\Seeders;

use App\Models\options;
use Database\Seeders\types\AccountIndustrySeeder;
use Database\Seeders\types\AddressRecordTypeSeeder;
use Database\Seeders\types\OwnershipRecordSeeder;
use Database\Seeders\types\RatingRecordTypeSeeder;
use Database\Seeders\types\WaterResourceTypeSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypeAllSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        options::truncate();
        DB::statement('ALTER SEQUENCE options_id_seq RESTART WITH 1000;');
        $this->call(WaterResourceTypeSeeder::class);
        $this->call(AccountIndustrySeeder::class);
        $this->call(AddressRecordTypeSeeder::class);
        $this->call(RatingRecordTypeSeeder::class);
        $this->call(OwnershipRecordSeeder::class);
        // $this->call(PropertyRecordTypeSeeder::class);
    }
}
