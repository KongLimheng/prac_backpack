<?php

namespace Database\Seeders\types;

use App\Traits\Type\CreateTypeSeederTrait;
use Illuminate\Database\Seeder;

class WaterResourceTypeSeeder extends Seeder
{
    use CreateTypeSeederTrait;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        request()->merge(['disableParentChildrenEvent' => true]);

        $arr = [
            2 => [
                "name" => "Property Water Resource",
                "name_khm" => "",
                "code" => '',
                "auto_code" => true
            ]
        ];

        $this->checkIfHaveParentAndCreate($arr);
        $this->forceDeleteWhereParentId([2]);

        $arrPropertyWaterResource = [
            [
                "name" => "Available Natural (Permanent)",
                "name_khm" => "",
                "code" => '',
                "auto_code" => true,
            ],
            [
                "name" => "Available Artificial (Temporary)",
                "name_khm" => "",
                "code" => '',
                "auto_code" => true,
            ],
        ];
        $this->runLooping(2, $arrPropertyWaterResource , 'option');
    }
}
