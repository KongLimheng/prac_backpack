<?php

namespace Database\Seeders\types;

use App\Traits\Type\CreateTypeSeederTrait;
use Illuminate\Database\Seeder;

class OwnershipRecordSeeder extends Seeder
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
            6 => [
                "name" => "Account ownership",
                "name_khm" => "",
                "code" => '',
                "auto_code" => true
            ]
        ];

        $this->checkIfHaveParentAndCreate($arr);
        $this->forceDeleteWhereParentId([6]);

        $arrPropertyWaterResource = [
            [
                "name" => "Public",
                "name_khm" => "",
                "code" => '',
                "auto_code" => true,
            ],
            [
                "name" => "	Private",
                "name_khm" => "",
                "code" => '',
                "auto_code" => true,
            ],
            [
                "name" => "Subsidiary",
                "name_khm" => "",
                "code" => '',
                "auto_code" => true,
            ],
            [
                "name" => "	Customer",
                "name_khm" => "",
                "code" => '',
                "auto_code" => true,
            ],
            [
                "name" => "	Brokerage",
                "name_khm" => "",
                "code" => '',
                "auto_code" => true,
            ],
            [
                "name" => "	Investor",
                "name_khm" => "",
                "code" => '',
                "auto_code" => true,
            ],
            [
                "name" => "	Property Management",
                "name_khm" => "",
                "code" => '',
                "auto_code" => true,
            ],
            [
                "name" => "Inspector",
                "name_khm" => "",
                "code" => '',
                "auto_code" => true,
            ],
            [
                "name" => "	Developer",
                "name_khm" => "",
                "code" => '',
                "auto_code" => true,
            ],
            [
                "name" => "	Appraiser",
                "name_khm" => "",
                "code" => '',
                "auto_code" => true,
            ],
            [
                "name" => "	Contractor",
                "name_khm" => "",
                "code" => '',
                "auto_code" => true,
            ],
            [
                "name" => "Builder",
                "name_khm" => "",
                "code" => '',
                "auto_code" => true,
            ],
            [
                "name" => "Consultant",
                "name_khm" => "",
                "code" => '',
                "auto_code" => true,
            ],
            [
                "name" => "Bank",
                "name_khm" => "",
                "code" => '',
                "auto_code" => true,
            ],
            [
                "name" => "Press",
                "name_khm" => "",
                "code" => '',
                "auto_code" => true,
            ],
            [
                "name" => "Other",
                "name_khm" => "",
                "code" => '',
                "auto_code" => true,
            ],
        ];
        $this->runLooping(6, $arrPropertyWaterResource , 'option');
    }
}
