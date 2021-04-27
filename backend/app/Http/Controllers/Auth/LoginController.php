<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use http\Client;
use Illuminate\Http\Request;
use Illuminate\Session;

use App\Google;
use Google\Auth\AccessToken;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    private $client;

    public function RedirectToProvider(Request $request)
    {
        $access_token = Socialite::driver('google')->getAccessTokenResponse($request->post('code'));
        $request->session()->put('access_token', $access_token);
        $user = Socialite::driver('google')->userFromToken($access_token['access_token']);
        return response()->json($user, 200);
    }

    // public function getUser(Request $request) {
    //     $user_info = $request->session()->get('user.info');

    //     if (!$user_info) {
    //         return response()->json(['success'=> false], 400);
    //     }

    //     $response = [
    //         "name" => $user_info->name,
    //         "email" => $user_info->email,
    //         "avatar" => $user_info->avatar
    //     ];
    //     return response()->json($response, 200);
    // }

    // public function logout(Request $request) {
    //     $request->session()->pull('user', 'default');
    //     return redirect()->back();
    // }

}
