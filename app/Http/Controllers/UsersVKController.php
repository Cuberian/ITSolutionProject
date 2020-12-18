<?php

namespace App\Http\Controllers;

use App\Models\UserVK;
use Illuminate\Http\Request;
use GuzzleHttp;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
class UsersVKController extends Controller
{
    protected $user;

    public function __construct() {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                $this->user = JWTAuth::parseToken()->authenticate();
            }
        }
        catch (JWTException $e) {
            response()->json(['token_expired']);
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return UserVK::all()->toArray();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param $userVK_id
     * @return \Psr\Http\Message\StreamInterface
     * @throws GuzzleHttp\Exception\GuzzleException
     */

    public function show($userVK_id)
    {
        $userVK = new GuzzleHttp\Client();
        $res = $userVK->request('GET', 'http://' . self::$host . '/toxicity_py/api/users/' . $userVK_id);
        return $res->getBody();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function get_posts($user_id)
    {
        $post = new GuzzleHttp\Client();
        $res = $post->request('GET', 'http://'. self::$host . '/toxicity_py/api/posts/' . $user_id);
        return $res->getBody();
    }
    public function get_subscribers($user_id)
    {
        $subscribers = new GuzzleHttp\Client();
        $res = $subscribers->request('GET', 'http://'. self::$host . '/toxicity_py/api/followers/'
            . $user_id);
        return $res->getBody();
    }

    public function get_subscriptions($user_id)
    {
        $subscriptions = new GuzzleHttp\Client();
        $res = $subscriptions->request('GET', 'http://'. self::$host . '/toxicity_py/api/subscriptions/'
            . $user_id);
        return $res->getBody();
    }

    public function post_message(Request $request)
    {
        $message = new GuzzleHttp\Client();
        $res = $message->request('POST', 'http://'. self::$host . '/toxicity_py/api/message',
            ['message' => $request->input('message')]);
        return $res->getBody();
    }

    public function post_messages(Request $request)
    {
        $messages = new GuzzleHttp\Client();
        $res = $messages->request('POST', 'http://'. self::$host . '/toxicity_py/api/messages',
            ['messages' => $request->input('messages')]);
        return $res->getBody();
    }
}
