<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Session;

use App\Google;
use Google\Auth\AccessToken;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{

    public function login() {
       $parameters = ['access_type' => 'offline'];
       return Socialite::driver('google')->scopes(["https://www.googleapis.com/auth/drive"])->with($parameters)->redirect();
    }

    public function handleProviderGoogleCalllback(Request $request) {
        $auth_token = Socialite::with('google')->getAccessTokenResponse($request->code);

        session(['auth_token'=> $auth_token]);

        return redirect(env('FRONTEND_URL'))->with(session('auth_token'));
    }

}
