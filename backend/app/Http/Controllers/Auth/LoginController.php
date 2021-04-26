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

    public function loginUser(Request $request) {
       $user = Socialite::with($request->provider)->stateless()->userFromToken($request->access_token);
       return response()->json($user, 200);
    }

    // public function handleProviderGoogleCalllback(Request $request) {
    //     $auth_token = Socialite::with('google')->getAccessTokenResponse($request->code);
    //     $user = Socialite::driver('google')->userFromToken($auth_token['access_token']);

    //     session([
    //         "user"=>[
    //             "token"=>$auth_token,
    //             "info"=>$user
    //         ]
    //     ]);

    //     return redirect(env('FRONTEND_URL'))->with(session('user'));
    // }

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
