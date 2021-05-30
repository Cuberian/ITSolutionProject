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


    public function testRequest(Request $request) {
        $client = new GuzzleHttp\Client();
        $res = $client->get('https://pokeapi.co/api/v2/pokemon/ditto');
    }

    public function getJWT(Request  $request) {
        $pwd_token = $request['pwd_token'];

        $host = Config::get('app.auth_host');
        $client = new GuzzleHttp\Client([
            'base_uri' => $host,
            'defaults' => [
                'exceptions' => false
            ]
        ]);
        $res = $client->request('GET',
            '/api/v1/user/current', [
                'headers' => [
                    'Authorization' => 'Bearer '.$pwd_token,
                    'Content-Type'=> 'application/json',
                    'Accept' => 'application/json'
                ]
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

    public function checkJWT(Request $request) {
        return response()->json(auth()->user());
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
            'user' => auth()->user(),
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
