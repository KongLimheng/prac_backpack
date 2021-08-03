<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Contacts;
use Illuminate\Http\Request;

class searchController extends Controller
{
    public function index(Request $request)
    {
        $search_term = $request->input('q');

        $result = new Contacts();
        if($search_term){
            $result = Contacts::WhereColumnConcats($search_term, ['salutation','first_name','last_name','phone']);
        }

        return [
            'data' => $result->paginate(10)->map(function($v){
                return [
                    'id' => $v->id,
                    'FullName' => $v->FullName
                ];
            })
        ];

    }

    public function searchAccount(Request $request)
    {
        $search_term = $request->input('q');
        if($search_term){
            $result = Account::where('name', 'LIKE', '%'.$search_term.'%')->paginate(10);
        }else{
            $result = Account:: paginate(10);
        }
        return $result;
    }
}
