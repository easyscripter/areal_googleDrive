<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Google;

class LoginController extends Controller
{

    public function login(Google $google, Request $request) {
        $client = $google->client();

        if ($request->has('code')) {

            $client->authenticate($request->input('code'));
            $token = $client->getAccessToken();

            session([
                'user' => [
                    'token' => $token
                ]
            ]);

            $request->session()->save();
            return redirect('/')->with(session('user.token'));
            
        } else {
            $auth_url = $client->createAuthUrl();
            return redirect($auth_url);
        }
   }

}
