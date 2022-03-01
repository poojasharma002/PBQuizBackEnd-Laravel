<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Cookie;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        if (Auth::check()) {
           return redirect()->route('dashboard');
        }
        else{
            return view('pages.login');
        }

    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        
        $request->authenticate();

        $request->session()->regenerate();
        if($request->has('remember')){
            Cookie::queue('adminuser',$request->email,24800);
            Cookie::queue('adminpwd',$request->password,24800);
        }else{
            Cookie::queue('adminuser',$request->email,-24800);
            Cookie::queue('adminpwd',$request->password,-24800);
        }
        return redirect()->intended(RouteServiceProvider::HOME)->withInput(
            $request->except('password')
        );;
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect(route('login'));
    }
}
