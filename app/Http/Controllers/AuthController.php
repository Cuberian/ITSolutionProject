<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public $loginAfterSignUp = true;
    public function login(Request $request) {
        $creds = $request->only("email", "password");
        $token = null;

        if(!$token = JWTAuth::attempt($creds))
        {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized'
            ], 401);
        }

        return response()->json([
            "status" => true,
            "token" => $token
        ]);
    }
    public function register(Request $request) {
        $this->validate($request, [
            "username" => "required|string",
            "email" => "required|email|unique:users",
            "password" => "required|string|min:6|max:32"
        ]);

        $user = new User();
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        if($this->loginAfterSignUp) {
            return $this->login($request);
        }

        return response()->json([
            "status" => true,
            "user" => $user
        ]);
    }

    public function logout(Request $request)
    {
        $this->validate($request, [
           "token" => "required"
        ]);

        try {
            JWTAuth::invalidate($request->token);
            return response()->json([
                "status" => true,
                "message" => "User logged out successfully"
            ]);
        }
        catch (JWTException $exception) {
            return response()->json([
                "status" => false,
                "message" => "Ops, the user can not be logged out"
            ]);
        }
    }
}
