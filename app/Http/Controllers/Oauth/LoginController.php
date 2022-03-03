<?php

namespace App\Http\Controllers\oauth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Http;


class LoginController extends Controller
{
    public function googleLogin(Request $request)
    {
        $headerToken = $request->header('Authorization');
        $response = Http::get('https://www.googleapis.com/oauth2/v3/userinfo?', [
            'access_token' => $headerToken
        ]);

            $googleToken = $headerToken;
            $username= $response["name"];
            $userEmail =$response["email"];
            $userProfilePic = $response["picture"];

        $userDetails = User::where('email',$userEmail )->first();
     

        if(!$userDetails){
            $userDetails = new User(); 
            $userDetails->token = $googleToken;
            $userDetails->name = $username;
            $userDetails->email = $userEmail;
            $userDetails->profile_pic = $userProfilePic;
            $userDetails->role = "user";
            $userDetails->save();

            $user_details = [
                'data' => $userDetails->token,
            ];
            $data = [
                'status' => 'success',
                'message' => 'User Logged In Successfully',
                'data' => $user_details,
                'error' => null
            ];

            return response()->json($data, 200);

        }else{

            $userDetails->token = $googleToken;
            $userDetails->save();

            $user_details = [
                'token' => $userDetails->token,
            ];
            $data = [
                'status' => 'success',
                'message' => 'User Logged In Successfully',
                'data' => $user_details,
                'error' => null
            ];

            return response()->json($data, 200);
        }



    }
}
?>

