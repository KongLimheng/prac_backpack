<?php

namespace Database\Seeders\types;

use App\Traits\Type\CreateTypeSeederTrait;
use Illuminate\Database\Seeder;

class AddressRecordTypeSeeder extends Seeder
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
            4 => [
                "name" => "Listing Api Location",
                "name_khm" => "",
                "code" => '',
                "auto_code" => true
            ]
        ];

        $this->checkIfHaveParentAndCreate($arr);
        $this->forceDeleteWhereParentId([4]);

        $arrPropertyWaterResource = [
            [
                "name" => "	Chamkar Mon",
                "name_khm" => "",
                "code" => '',
                "auto_code" => true,
            ],
            [
                "name" => "Doun Penh",
                "name_khm" => "",
                "code" => '',
                "auto_code" => true,
            ],
            [
                "name" => "Prampir Meakkakra",
                "name_khm" => "",
                "code" => '',
                "auto_code" => true,
            ],
            [
                "name" => "Tuol Kouk",
                "name_khm" => "",
                "code" => '',
                "auto_code" => true,
            ],
            [
                "name" => "Dangkao",
                "name_khm" => "",
                "code" => '',
                "auto_code" => true,
            ],
            [
                "name" => "Mean Chey",
                "name_khm" => "",
                "code" => '',
                "auto_code" => true,
            ],
            [
                "name" => "Russey Keo",
                "name_khm" => "Saensokh",
                "code" => '',
                "auto_code" => true,
            ],
            [
                "name" => "Saensokh",
                "name_khm" => "",
                "code" => '',
                "auto_code" => true,
            ],
            [
                "name" => "Pur SenChey",
                "name_khm" => "",
                "code" => '',
                "auto_code" => true,
            ],
            [
                "name" => "Chraoy Chongvar",
                "name_khm" => "",
                "code" => '',
                "auto_code" => true,
            ],
            [
                "name" => "Praek Pnov",
                "name_khm" => "",
                "code" => '',
                "auto_code" => true,
            ],
            [
                "name" => "Chbar Ampov",
                "name_khm" => "",
                "code" => '',
                "auto_code" => true,
            ],
            [
                "name" => "Boeng Keng Kang",
                "name_khm" => "",
                "code" => '',
                "auto_code" => true,
            ],
            [
                "name" => "Kamboul",
                "name_khm" => "",
                "code" => '',
                "auto_code" => true,
            ],
            [
                "name" => "Banteay Meanchey",
                "name_khm" => "",
                "code" => '',
                "auto_code" => true,
            ],
            [
                "name" => "Battambang",
                "name_khm" => "",
                "code" => '',
                "auto_code" => true,
            ],
            [
                "name" => "Kampong Cham",
                "name_khm" => "",
                "code" => '',
                "auto_code" => true,
            ],
            [
                "name" => "Kampong Chhnang",
                "name_khm" => "",
                "code" => '',
                "auto_code" => true,
            ],
            [
                "name" => "	Kampong Speu",
                "name_khm" => "",
                "code" => '',
                "auto_code" => true,
            ],
            [
                "name" => "Kampong Thom",
                "name_khm" => "",
                "code" => '',
                "auto_code" => true,
            ],
            [
                "name" => "Kampot",
                "name_khm" => "",
                "code" => '',
                "auto_code" => true,
            ],
            [
                "name" => "Kandal",
                "name_khm" => "",
                "code" => '',
                "auto_code" => true,
            ],
            [
                "name" => "	Koh Kong",
                "name_khm" => "",
                "code" => '',
                "auto_code" => true,
            ],
            [
                "name" => "Kratie",
                "name_khm" => "",
                "code" => '',
                "auto_code" => true,
            ],
            [
                "name" => "Mondul Kiri",
                "name_khm" => "",
                "code" => '',
                "auto_code" => true,
            ],
            [
                "name" => "Preah Vihear",
                "name_khm" => "",
                "code" => '',
                "auto_code" => true,
            ],
            [
                "name" => "Prey Veng",
                "name_khm" => "",
                "code" => '',
                "auto_code" => true,
            ],
            [
                "name" => "Pursat",
                "name_khm" => "",
                "code" => '',
                "auto_code" => true,
            ],
            [
                "name" => "Ratanak Kiri",
                "name_khm" => "",
                "code" => '',
                "auto_code" => true,
            ],
            [
                "name" => "	Siemreap",
                "name_khm" => "",
                "code" => '',
                "auto_code" => true,
            ],
            [
                "name" => "Preah Sihanouk",
                "name_khm" => "",
                "code" => '',
                "auto_code" => true,
            ],
            [
                "name" => "Stung Treng",
                "name_khm" => "",
                "code" => '',
                "auto_code" => true,
            ],
            [
                "name" => "	Svay Rieng",
                "name_khm" => "",
                "code" => '',
                "auto_code" => true,
            ],
            [
                "name" => "Takeo",
                "name_khm" => "",
                "code" => '',
                "auto_code" => true,
            ],
            [
                "name" => "Oddar Meanchey",
                "name_khm" => "",
                "code" => '',
                "auto_code" => true,
            ],
            [
                "name" => "Kep",
                "name_khm" => "",
                "code" => '',
                "auto_code" => true,
            ],
            [
                "name" => "	Pailin",
                "name_khm" => "",
                "code" => '',
                "auto_code" => true,
            ],
            [
                "name" => "Tboung Khmum	",
                "name_khm" => "",
                "code" => '',
                "auto_code" => true,
            ],
        ];
        $this->runLooping(4, $arrPropertyWaterResource , 'option');
    }
}
