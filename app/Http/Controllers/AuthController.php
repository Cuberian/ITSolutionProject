<?php

namespace App\Http\Controllers;

use App\Models\User;
use GuzzleHttp;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\DocBlock\Tags\Uses;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    //public $loginAfterSignUp = true;


    public function getJWT(Request  $request) {
        $pwd_token = $request['pwd_token'];

        $client = new GuzzleHttp\Client();
        $host = Config::get('app.auth_host');
        $res = $client->get(
            $host . '/api/v1/user/current', [
                'headers' => ['Authorization' => 'Bearer '.$pwd_token, 'Content-Type'=> 'application/json'],
            ]);


        $user_data = json_decode((string) $res->getBody());
        $user = User::updateOrCreate(['email'=>$user_data->email],collect($user_data)->toArray());

        $token = auth()->login($user);

        if(!$token)
        {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized'
            ], 401);
        }

        return $this->respondWithToken($token);
    }

    public function invalidateToken()
    {
        auth()->invalidate();
    }

    /**
     * Refresh a token.
     *
     * @return JsonResponse
     */
    public function refresh(): JsonResponse
    {
        return $this->respondWithToken(auth()->refresh());
    }

    protected function respondWithToken($token): JsonResponse
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
