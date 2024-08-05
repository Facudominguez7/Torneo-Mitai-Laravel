<?php

namespace App\Http\Controllers\Google;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    public function callback()
    {
        $user_google = Socialite::driver('google')->stateless()->user();
        $usuario_existente = User::where('google_id', $user_google->id)->first();

        if ($usuario_existente) {
            auth()->login($usuario_existente);
            return redirect()->intended(route('home'));
        } else {
            $user = new User();
            $user->google_id = $user_google->id;
            $user->name = $user_google->name;
            $user->email = $user_google->email;
            $user->google_avatar = $user_google->avatar;
            $user->google_token = $user_google->token;

            $user->save();
            auth()->login($user);

            return redirect()->intended(route('home'));
        }
    }

    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }
}
