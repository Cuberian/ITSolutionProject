<?php

namespace App\Http\Middleware;

use Closure;
use GuzzleHttp;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;

class AuthCheckMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if($request->query("token"))
        {
            try {
                $auth = new GuzzleHttp\Client();
                $res = $auth->request('GET', 'http://toxicauth/api/check?token=' . $request->query("token"));

                if($res->getStatusCode() === 200)
                {
                    return $next($request);
                }
                else {
                    return response()->json(['result' => 'unauthorized']);
                }
            } catch (ClientException $e) {
                return  response()->json(json_decode($e->getResponse()->getBody()->getContents()));
            }
        }
        else {
            return response()->json(['type' => 'Error', 'message'=>'user unauthorized']);
        }
    }
}
