<?php

namespace App\Http\Controllers\oauth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;



class LoginController extends Controller
{
    public function googleLogin(Request $request)
    {
    
            $googleToken = $request->input('token');
            $username= $request->input('name');
            $userEmail = $request->input('email');

        //check if user exists
        $userDetails = User::where('email',$userEmail )->first();
        if(!$userDetails){
            //create new user     
            $userDetails->token = $googleToken;
            $userDetails->name = $username;
            $userDetails->email = $userEmail;
            $userDetails->save();
            return response()->json(['access_token'=>$user->token]);
        }else{
            //update token where email matches
            $userDetails->token = $googleToken;
            $userDetails->save();
            return response()->json(['access_token'=>$userDetails->token]);
        }



    }
}
?>

