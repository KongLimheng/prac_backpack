<?php

namespace Database\Seeders\types;

use App\Traits\Type\CreateTypeSeederTrait;
use Illuminate\Database\Seeder;

class RatingRecordTypeSeeder extends Seeder
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
            5 => [
                "name" => "Lead Rating",
                "name_khm" => "",
                "code" => '',
                "auto_code" => true
            ]
        ];

        $this->checkIfHaveParentAndCreate($arr);
        $this->forceDeleteWhereParentId([5]);

        $arrPropertyWaterResource = [
            [
                "name" => "Cold",
                "name_khm" => "",
                "code" => '',
                "auto_code" => true,
            ],
            [
                "name" => "Warm",
                "name_khm" => "",
                "code" => '',
                "auto_code" => true,
            ],
            [
                "name" => "Hot",
                "name_khm" => "",
                "code" => '',
                "auto_code" => true,
            ],
        ];
        $this->runLooping(5, $arrPropertyWaterResource , 'option');
    }
}
