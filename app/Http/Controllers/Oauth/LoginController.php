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
        // $headerToken = $request->header('Authorization');
        // $response = Http::get('https://www.googleapis.com/oauth2/v3/userinfo?', [
        //     'access_token' => $headerToken
        // ]);
        $response= Http::get('https://www.googleapis.com/oauth2/v3/userinfo?', [
            'access_token' => $request->access_token
        ]);

            $googleToken = $request->access_token;
            $username= $response["name"];
            $userEmail =$response["email"];
            $userProfilePic = $response["picture"];


        $userDetails = User::where('email',$userEmail )
        ->where('role','user')
        ->first();


        if(!$userDetails){
            $userDetails = new User(); 
            $userDetails->token = $googleToken;
            $userDetails->name = $username;
            $userDetails->email = $userEmail;
            $userDetails->profile_pic = $userProfilePic;
            $userDetails->role = "user";
            $userDetails->save();

            $user_details = [
                'user_id'=>$userDetails->id,
                'data' => $userDetails->token,
                'status' => $userDetails->status
            ];

            //check if user is not active
            if($userDetails->status == 0){
                return response()->json([
                    'success' => false,
                    'data' => null,
                    'error' => 'User is not active.',
                    'status' => 401
                ], 401);
            }
            else{
                $data = [
                    'status' => 'success',
                    'message' => 'User Logged In Successfully',
                    'data' => $user_details,
                    'error' => null
                ];
    
                return response()->json($data, 200);
            }


        }else{

            $userDetails->token = $googleToken;
            $userDetails->save();

            $user_details = [
                'user_id'=>$userDetails->id,
                'token' => $userDetails->token,
                'status' => $userDetails->status
            ];

            //check if user is not active
            if($userDetails->status == 0){
                return response()->json([
                    'success' => false,
                    'data' => null,
                    'error' => 'User is not active.',
                    'status' => 401
                ], 401);
            }
            else{
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

    public function facebookLogin(Request $request)
    {
        $responseFacebook= Http::get('https://graph.facebook.com/me?access_token=', [
            'access_token' => $request->access_token
        ]);

        if(!isset($responseFacebook['error'])){
            $facebookToken = $request->access_token;
            $username = $responseFacebook['name'];
            $userEmail = $request->email;
            $userProfilePic = $request->profile_pic;

            $userDetails = User::where('email',$userEmail )
            ->where('role','user')
            ->first();
           
            if(!$userDetails){
                $userDetails = new User();
                $userDetails->token = $facebookToken;
                $userDetails->name = $username;
                $userDetails->email = $userEmail;
                $userDetails->profile_pic = $userProfilePic;
                $userDetails->role = "user";
                $userDetails->save();

                $user_details = [
                    'user_id'=>$userDetails->id,
                    'data' => $userDetails->token,
                    'status' => $userDetails->status,
                    'name' => $userDetails->name,
                    'email' => $userDetails->email
                ];

                //check if user is not active
                if($userDetails->status == 0){
                    return response()->json([
                        'success' => false,
                        'data' => null,
                        'error' => 'User is not active.',
                        'status' => 401
                    ], 401);
                }
                else{
                    $data = [
                        'status' => 'success',
                        'message' => 'User Logged In Successfully',
                        'data' => $user_details,
                        'error' => null
                    ];
        
                }

            }else{
                $userDetails->profile_pic = $request->profile_pic;
                $userDetails->token = $facebookToken;
                $userDetails->save();

                $user_details = [
                    'user_id'=>$userDetails->id,
                    'token' => $userDetails->token,
                    'status' => $userDetails->status,
                    'name' => $userDetails->name,
                    'email' => $userDetails->email
                ];

                //check if user is not active
                if($userDetails->status == 0){
                    return response()->json([
                        'success' => false,
                        'data' => null,
                        'error' => 'User is not active.',
                        'status' => 401
                    ], 401);
                }
                else{
                    $data = [
                        'status' => 'success',
                        'message' => 'User Logged In Successfully',
                        'data' => $user_details,
                        'error' => null
                    ];
        

                }


            }


        }else{
            $data = [
                'status' => 'error',
                'message' => 'User Not Found',
                'data' => null,
                'error' => $responseFacebook['error']['message']
            ];
        }

        return response()->json($data, 200);

    }

}
?>

