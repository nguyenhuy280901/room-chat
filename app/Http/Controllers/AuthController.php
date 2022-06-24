<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Validator;
use Hash;
use Auth;

class AuthController extends Controller
{
    function login(Request $request){
        $remember_me = isset($request->remember_me);
        if(Auth::attempt([
            'email' => $request->email,
            'password' => $request->password
        ], $remember_me)){
            return redirect()->route('choose-room');
        }
        return redirect()->back()->with('error-login' ,'Username or password invalid')->withInput($request->all());
    }

    function logout(){
        Auth::logout();
        return redirect()->route('home');
    }
    
    function register(Request $request){
        $validator = Validator::make($request->all(), [
            "name" => "required|max:100",
            "email" => "required|max:100|email:rfc,dns|unique:user",
            "password" => "required|confirmed|max:100|min:8",
            "avatar" => "required",
        ]);

        if($validator->fails()){
            return redirect()->back()->with('error-register' ,'Invalid data');
        }

        $user = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password),
            "login_by" => "form",
        ]);

        $avatar = $request->avatar;
        $fileExtension = $avatar->getClientOriginalExtension();
        $fileName = "user-avt-" . $user->id . "." . $fileExtension;
        $destinationPath = "images/user_avt/";
        $avatar->move($destinationPath, $fileName);

        $user->avatar = $fileName;
        $user->save();

        Auth::login($user, FALSE);

        return redirect()->route('choose-room');
    }
}
