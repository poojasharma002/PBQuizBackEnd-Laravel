<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function userProfile(Request $request)
    {
        $headerToken = $request->header('Authorization');
        $user = User::where('token', $headerToken)->first();
        if (!$user) {
            return response()->json([
                'success' => false,
                'data' => null,
                'error' => 'User not found.',
                'status' => 401
            ], 401);
        }else{
            $data = [
                'success' => true,
                'data' => $user,
                'error' => null,
                'status' => 200
            ];
            return response()->json([$data], 200);
        }


    }

    public function changeProfilePicture(Request $request)
    {
        $headerToken = $request->header('Authorization');
        $user = User::where('token', $headerToken)->first();
        if (!$user) {
            return response()->json([
                'success' => false,
                'data' => null,
                'error' => 'User not found.',
                'status' => 401
            ], 401);
        }else{
            $request->validate([
                'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            $image = $request->file('profile_picture');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('images_pic'), $imageName);
            $imagePath = 'images_pic/'.$imageName;
            $user->profile_pic = $imagePath;
            $user->save();


            $data = [
                'success' => true,
                'data' => $user,
                'error' => null,
                'status' => 200
            ];
            return response()->json([$data], 200);
        }
    }
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
