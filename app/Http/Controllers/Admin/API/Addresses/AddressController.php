<?php

namespace App\Http\Controllers\Admin\API\Addresses;

use App\Http\Controllers\Controller;
use App\Models\Address;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    protected $fieldCode = '_code';

    public function index(Request $request)
    {
        $locale = app()->getLocale();
        return Address::where($this->fieldCode, 'Like', $request->code."__")
            ->orderBy('_name_'. $locale)->pluck($this->fieldCode, '_name_'.$locale);
        
    }
}
