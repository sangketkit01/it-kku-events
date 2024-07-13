<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class GoogleAuthController extends Controller
{
    //
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callbackGoogle()
    {
        try {
            $google_user = Socialite::driver('google')->user();
            $user = DB::table('userdbs')->where('email', $google_user->getEmail())->first();

            $is_kku = str_ends_with($google_user->getEmail(), "kkumail.com") ? true : false;
            if ($is_kku == false) {
                return redirect()->route('sign_in')->with('not_kku', "not a kku guy");
            }
            if (!$user) {
                $new_user = [
                    "email" => $google_user->getEmail(),
                    "is_kku" => $is_kku,
                    'google_id' => $google_user->getId(),
                ];

                DB::table('userdbs')->insert($new_user);

                $user = DB::table('userdbs')->where('email', $google_user->getEmail())->first();
            }

            Session::put('user', $user);

            $data = DB::table('userdbs')->first();
            $avatar = $google_user->getAvatar();
            $name = explode(" ", $google_user->getName())[0];
            $user_email = $google_user->getEmail();


            $user_data = DB::table('userdbs')->where('email', $google_user->getEmail())->first();
            Session::put('name', $name);
            Session::put('avatar', $avatar);
            Session::put('user_email', $user_data->email);

            //dd($user_data->is_it);

            if (is_null($user_data->is_it) || $user_data->is_it == 0) {
                return redirect()->route('check')->with('email', $user_email);
            }

            if (!Session::has('is_it')) {
                Session::put('is_it', $user_data->is_it);
            }

            return redirect()->route('index')->with('data', $data);
        } catch (\Throwable $th) {
            dd($th);
            return redirect()->route('sign_in')->withErrors(['msg' => 'Login failed. Please try again.']);
        }
    }
}
