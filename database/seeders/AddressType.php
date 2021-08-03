<?php

namespace Database\Seeders;

use App\Traits\Type\CreateTypeSeederTrait;
use Illuminate\Database\Seeder;

class AddressType extends Seeder
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
            7 => [
                "name" => "Listing Api Location",
                "name_khm" => "",
                "code" => '',
                "auto_code" => true
            ]
        ];

        $this->checkIfHaveParentAndCreate($arr);
        $this->forceDeleteWhereParentId([7]);

        $arrPropertyWaterResource = [
                [
                    "name" => "Chamkar Mon",
                    "name_khm" => "ចំការមន",
                    "code" => 1201,
                    "auto_code" => true
                ],
                [
                    "name" => "Doun Penh",
                    "name_khm" => "ដូនពេញ",
                    "code" => 1202,
                    "auto_code" => true
                ],
                [
                    "name" => "Prampir Meakkakra",
                    "name_khm" => "៧មករា",
                    "code" => 1203,
                    "auto_code" => true
                ],
                [
                    "name" => "Tuol Kouk",
                    "name_khm" => "ទួលគោក",
                    "code" => 1204,
                    "auto_code" => true
                ],
                [
                    "name" => "Dangkao",
                    "name_khm" => "ដង្កោ",
                    "code" => 1205,
                    "auto_code" => true
                ],
                [
                    "name" => "Mean Chey",
                    "name_khm" => "មានជ័យ",
                    "code" => 1206,
                    "auto_code" => true
                ],
                [
                    "name" => "Russey Keo",
                    "name_khm" => "ឫស្សីកែវ",
                    "code" => 1207,
                    "auto_code" => true
                ],
                [
                    "name" => "Saensokh",
                    "name_khm" => "សែនសុខ",
                    "code" => 1208,
                    "auto_code" => true
                ],
                [
                    "name" => "Pur SenChey",
                    "name_khm" => "ពោធិ៍សែនជ័យ",
                    "code" => 1209,
                    "auto_code" => true
                ],
                [
                    "name" => "Chraoy Chongvar",
                    "name_khm" => "ជ្រោយចង្វារ",
                    "code" => 1210,
                    "auto_code" => true
                ],
                [
                    "name" => "Praek Pnov",
                    "name_khm" => "ព្រែកព្នៅ",
                    "code" => 1211,
                    "auto_code" => true
                ],
                [
                    "name" => "Chbar Ampov",
                    "name_khm" => "ច្បារអំពៅ",
                    "code" => 1212,
                    "auto_code" => true
                ],
                [
                    "name" => "Boeng Keng Kang",
                    "name_khm" => "បឹងកេងកង",
                    "code" => 1213,
                    "auto_code" => true
                ],
                [
                    "name" => "Kamboul",
                    "name_khm" => "កំបូល",
                    "code" => 1214,
                    "auto_code" => true
                ],
                [
                    "name" => "Banteay Meanchey",
                    "name_khm" => "បន្ទាយមានជ័យ",
                    "code" => "01",
                    "auto_code" => true
                ],
                [
                    "name" => "Battambang",
                    "name_khm" => "បាត់ដំបង",
                    "code" => "02",
                    "auto_code" => true
                ],
                [
                    "name" => "Kampong Cham",
                    "name_khm" => "កំពង់ចាម",
                    "code" => "03",
                    "auto_code" => true
                ],
                [
                    "name" => "Kampong Chhnang",
                    "name_khm" => "កំពង់ឆ្នាំង",
                    "code" => "04",
                    "auto_code" => true
                ],
                [
                    "name" => "Kampong Speu",
                    "name_khm" => "កំពង់ស្ពឺ",
                    "code" => "05",
                    "auto_code" => true
                ],
                [
                    "name" => "Kampong Thom",
                    "name_khm" => "កំពង់ធំ",
                    "code" => "06",
                    "auto_code" => true
                ],
                [
                    "name" => "Kampot",
                    "name_khm" => "កំពត",
                    "code" => "07",
                    "auto_code" => true
                ],
                [
                    "name" => "Kandal",
                    "name_khm" => "កណ្ដាល",
                    "code" => "08",
                    "auto_code" => true
                ],
                [
                    "name" => "Koh Kong",
                    "name_khm" => "កោះកុង",
                    "code" => "09",
                    "auto_code" => true
                ],
                [
                    "name" => "Kratie",
                    "name_khm" => "ក្រចេះ",
                    "code" => 10,
                    "auto_code" => true
                ],
                [
                    "name" => "Mondul Kiri",
                    "name_khm" => "មណ្ឌលគិរី",
                    "code" => 11,
                    "auto_code" => true
                ],
                [
                    "name" => "Preah Vihear",
                    "name_khm" => "ព្រះវិហារ",
                    "code" => 13,
                    "auto_code" => true
                ],
                [
                    "name" => "Prey Veng",
                    "name_khm" => "ព្រៃវែង",
                    "code" => 14,
                    "auto_code" => true
                ],
                [
                    "name" => "Pursat",
                    "name_khm" => "ពោធិ៍សាត់",
                    "code" => 15,
                    "auto_code" => true
                ],
                [
                    "name" => "Ratanak Kiri",
                    "name_khm" => "រតនគិរី",
                    "code" => 16,
                    "auto_code" => true
                ],
                [
                    "name" => "Siemreap",
                    "name_khm" => "សៀមរាប",
                    "code" => 17,
                    "auto_code" => true
                ],
                [
                    "name" => "Preah Sihanouk",
                    "name_khm" => "ព្រះសីហនុ",
                    "code" => 18,
                    "auto_code" => true
                ],
                [
                    "name" => "Stung Treng",
                    "name_khm" => "ស្ទឹងត្រែង",
                    "code" => 19,
                    "auto_code" => true
                ],
                [
                    "name" => "Svay Rieng",
                    "name_khm" => "ស្វាយរៀង",
                    "code" => 20,
                    "auto_code" => true
                ],
                [
                    "name" => "Takeo",
                    "name_khm" => "តាកែវ",
                    "code" => 21,
                    "auto_code" => true
                ],
                [
                    "name" => "Oddar Meanchey",
                    "name_khm" => "ឧត្ដរមានជ័យ",
                    "code" => 22,
                    "auto_code" => true
                ],
                [
                    "name" => "Kep",
                    "name_khm" => "កែប",
                    "code" => 23,
                    "auto_code" => true,
                ],
                [
                    "name" => "Pailin",
                    "name_khm" => "ប៉ៃលិន",
                    "code" => 24,
                    "auto_code" => true,
                ],
                [
                    "name" => "Tboung Khmum",
                    "name_khm" => "ត្បូងឃ្មុំ",
                    "code" => 25,
                    "auto_code" => true,
                ]
        ];
        $this->runLooping(7, $arrPropertyWaterResource , 'option');

    }
}