<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Mail;




class SignupLoginController extends Controller
{
    public function register(Request $request)
    {
       
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
            'role' => 'user',
            'status' => 1,
        ]);
        
        $data = [
            'success' => true,
            'data' => $user,
            'error' => null,
            'status' => 200
        ];

        return response()->json([$data], 200);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
        ]);
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'data' => null,
                'error' => 'User not found.',
                'status' => 401
            ], 401);
        }else{
            if (Hash::check($request->password, $user->password)) {
            
                //generate random string for token
                $token = Str::random(211);
                $user->token = $token;
                $user->save();
    
                $data = [
                    'success' => true,
                    'message' => 'User Logged In Successfully',
                    'data' => $user,
                    'error' => null,
                    'status' => 200
                ];
    
                return response()->json([ $data], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'data' => null,
                    'error' => 'Password is incorrect.',
                    'status' => 401
                ], 401);
            }
        }

    
    }

    public function forgetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email|max:255',
        ]);

        $user = User::where('email', $request->email)->first();
        

        if (!$user) {
            return response()->json([
                'success' => false,
                'data' => null,
                'error' => 'User not found.',
                'status' => 401
            ], 401);
        }

        
        //else send email to user with reset password link to that email
        else{
            $to_name = $user->name;
        $to_email = $user->email;
                $data = array('name'=>$to_name, "body" => "http://127.0.0.1:8000/reset-password");
                Mail::send('emails.mail', $data, function($message) use ($to_name, $to_email) {
                        $message->to($to_email, $to_name)->subject('Pb Quiz Password Reset Link'); 
                        $message->from('surajtest0987@gmail.com','OTP for email verificatin Cynoteck Canteen');
                });
    
    
                if (Mail::failures()) {
                    return response()->json(["error"=>"email not sent","status"=>401],401);
                }else{
                    // $employee->password = Hash::make($request->password);
                    // $employee->otp = $otp;
                    // $employee->save();
                    return response()->json(["data"=>"Reset has been sent to your mail - ".$to_email,"status"=>200],200);
                }
            //send email to user with reset password link to that email
            $data = [
                'success' => true,
                'message' => 'Password reset link sent to your email.',
                'data' => $user,
                'error' => null,
                'status' => 200
            ];

            return response()->json([ $data], 200);
        }

        return response()->json([ $data], 200);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email'=> 'required|string|email|max:255',
            'password' => 'required|string|min:6',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'data' => null,
                'error' => 'User not found.',
                'status' => 401
            ], 401);
        }

        else{
            $user->password = Hash::make($request->password);
            $user->save();
    
            $data = [
                'success' => true,
                'message' => 'Password reset successfully.',
                'data' => $user,
                'error' => null,
                'status' => 200
            ];
        }

        return response()->json([ $data], 200);
    }
}
