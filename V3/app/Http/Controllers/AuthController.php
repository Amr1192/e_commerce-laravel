<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\SignupRequest;
use App\Models\User;
use App\Services\CartService;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('Auth.login');
    }

    public function login(LoginRequest $request, CartService $cartService)
    {
        $credentials = $request->validated();

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $guestCart = $request->session()->get('guest_cart', []);
            if (is_array($guestCart) && $guestCart !== []) {
                $cartService->mergeGuestSessionIntoUser(Auth::user(), $guestCart);
                $cartService->forgetGuestSession($request);
            }

            return redirect()->intended(route('products.index'));
        }

        return back()->withErrors(
            ['email' => 'the provided credentials doesn\'t match our records']
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

    public function signup(SignupRequest $request, CartService $cartService)
    {
        $credentials = $request->validated();
        $user = User::create($credentials);

        $guestCart = $request->session()->get('guest_cart', []);
        if (is_array($guestCart) && $guestCart !== []) {
            $cartService->mergeGuestSessionIntoUser($user, $guestCart);
            $cartService->forgetGuestSession($request);
        }

        Auth::login($user);

        return redirect()->intended(route('products.index'));
    }
}
