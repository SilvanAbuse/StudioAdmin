<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

//use JWTAuth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\User;
use App\Ads;
use Illuminate\Support\Facades\Hash;


class TokenAuthController extends Controller
{
    public function register(Request $request)
    {
        if (!$request->email)
            return response()->json(['error' => 'need email'], 400);
        if (!$request->password)
            return response()->json(['error' => 'need password'], 401);
        if (!$request->name)
            return response()->json(['error' => 'need name'], 402);

        $email = strtolower($request->email);
        $credentials = $request->all();
        $credentials['password'] = Hash::make($request->input('password'));
        $new_user = User::create($credentials);
        return response()->json(['success' => 'user registered'], 200);
    }
    public function authenticate(Request $request)
    {
        if (!$request->email)
            return response()->json(['error' => 'need email'], 400);
        if (!$request->password)
            return response()->json(['error' => 'need password'], 401);
        $email = strtolower($request->email);
        $credentials = ['email' => $email, 'password' => $request->password];

        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }
        return response()->json(compact('token'));
    }
    public function get_ads()
    {
        $ads = Ads::get();
        return response()->json($ads, 200);
    }
}
