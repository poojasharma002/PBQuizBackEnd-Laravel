<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{

    public function changePassword(Request $request)
    {
       $headerToken = $request->header('Authorization');
       $user = User::where('token', $headerToken)->first();

       
        //old password is  INcorrect
        if (!Hash::check($request->old_password, $user->password)) {
            return response()->json([
                'success' => false,
                'data' => null,
                'error' => 'Old password is incorrect.',
                'status' => 401
            ], 401);
        }else{
            $user->password = Hash::make($request->new_password);
            $user->save();
            return response()->json([
                'success' => true,
                'data' => $user,
                'error' => null,
                'status' => 200
            ], 200);
        }

    }
}
