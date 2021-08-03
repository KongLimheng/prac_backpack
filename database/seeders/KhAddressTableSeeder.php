<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class KhAddressTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
          //Why split sql file? coz 1 file can not more than 10000 lines.
          if (env('DB_CONNECTION') === 'pgsql') {
            DB::unprepared(Storage::disk('generator')->get('kh_address.sql'));
            DB::unprepared(Storage::disk('generator')->get('kh_address_2.sql'));
            DB::unprepared(Storage::disk('generator')->get('kh_address_3.sql'));
        } else {
            DB::unprepared(Storage::disk('generator')->get('address.sql'));
            DB::unprepared(Storage::disk('generator')->get('address_2.sql'));
            DB::unprepared(Storage::disk('generator')->get('address_3.sql'));
        }
    }
}
