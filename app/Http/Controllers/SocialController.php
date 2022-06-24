<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Socialite;
use App\Models\User;

class SocialController extends Controller
{
    public function redirect($social){
        return Socialite::driver($social)->redirect();
    }
    public function callback($social){
        $socialUser = Socialite::driver($social)->user();
        if(User::where('email', $user->email)->whereNotIn('login_by', [$social])->first() instanceof User){
            return redirect()->route('home');
        }

        $user = User::firstOrNew([
            "email" => $socialUser->email,
            "password" => "",
            "login_by" => $social,
        ]);

        if (!$user->exists){
            // user created from 'new', does not exist in database.
            $user->name = $socialUser->name;
            $user->avatar = $socialUser->avatar;
            $user->save();
        }

        Auth::login($user, false);
        return redirect()->route('home');
    }
}
