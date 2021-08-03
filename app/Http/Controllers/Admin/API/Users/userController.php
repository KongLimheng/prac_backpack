<?php

namespace App\Http\Controllers\Admin\API\Users;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class userController extends Controller
{
    public function store(Request $request){
        $this->validate($request, [
            'password' => 'required|confirmed',
        ]);

        $user = User::create([
            'name' => $request->FullName,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => $request->password
        ]);

        if($user){
            DB::table('contacts')->where('id', $request->id)->update(['user_id'=> $user->id]);
        }

        return \Response::json($user);
    }
}
