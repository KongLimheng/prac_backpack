<?php

namespace App\Traits\Type;

use App\Models\options;

trait CreateTypeSeederTrait
{
    protected function checkIfHaveParentAndCreate($arr)
    {
        foreach ($arr as $k => $val) {
            $checkParent = options::where('id', $k)->first();
            if (!$checkParent) {
                options::firstOrCreate([
                    'id' => $k,
                    'name' => $val['name'],
                    'name_khm' => $val['name_khm'] ? $val['name_khm'] : $val['name'],
                    'code' => $val['name'],
                    'parent_id' => 0,
                ]);
            }
        }
    }

    protected function forceDeleteWhereParentId($parentIds)
    {
        options::whereIn('parent_id', $parentIds)->forceDelete();
    }
    protected function runLooping($parentValue, $children = [], $option = 'option')
    {
        if (!$parentValue) {
            return false;
        }

        $option_check = 0;
        $category_check = 0;

        if ($option == 'option') {
            $option_check = 1;
        } else {
            $category_check = 1;
        }

        if (is_array($children) && count($children)) {
            foreach ($children as $key => $value) :
                $this->checkChild($value, $parentValue, $option_check, $category_check);
            endforeach;
        }
    }
    protected function checkChild($value, $parentValue, $option_check, $category_check)
    {
        if (array_key_exists('child', $value) && is_array($value['child']) && count($value['child'])) {
            $pparent = $this->firstOrCreateType($value, $parentValue, $option_check, $category_check);

            foreach ($value['child'] as $kk => $vv) :
                $this->checkChild($vv, $pparent->id, $option_check, $category_check);
            endforeach;
        } else {
            $this->firstOrCreateType($value, $parentValue, $option_check, $category_check);
        }
    }

    protected function firstOrCreateType($value, $parentValue, $option_check, $category_check)
    {
        // dd($parentValue);
        return options::firstOrCreate([
            'name' => $value['name'],
            'name_khm' => $value['name_khm'] ? $value['name_khm'] : $value['name'],
            'code' => $value['code'] ? $value['code'] : $value['name'],
            'parent_id' => $parentValue,
        ]);
    }
}
