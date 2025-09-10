<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\SignupRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
 
    public function showLogin()
    {
      return view('Auth.login');
    }

    public function login(LoginRequest $request )
    {
       $credentials  = $request->validated();

        if(Auth::attempt($credentials)) {
            $request->session()->regenerate();
               return redirect()->intended('/');
        }

        else return back()->withErrors(
           [ 'email' => 'the provided credentials doesn\'t match our records']
        )->withInput();
    }

    
     public function logout()
    {
        Auth::logout();
        request()->session()->invalidate(); 
        request()->session()->regenerateToken();

        return redirect('/'); 
    }
    

 
    public function showSignup()
    {
        return view('Auth.signup');
    }


    public function signup(SignupRequest $request)
    {
       $credentials = $request->validated();
       $user = User::create($credentials);
       Auth::login($user);
       return redirect('/');
    }


}
