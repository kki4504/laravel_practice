<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class KakaoAuthController extends Controller
{
    //
    public function __construct()
    {   
        $this -> middleware(['guest']);
    }
    function redirect() {
        return Socialite::driver('kakao')->redirect();
    }
    function callback() {
        $user = Socialite::driver('kakao')->user();
        $user = User::firstOrCreate([
            'email'     => $user -> getEmail()],
            ['password' => Hash::make(Str::random(24)),
            'name'      => $user -> getName()]
        );
        Auth::login($user);

        return redirect()->intended('/dashboard');
    }

}
