<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserVK;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7;
use Illuminate\Http\Request;
use GuzzleHttp;
use Illuminate\Support\Facades\Config;

class UsersVKController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return array
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
        $storeData = $request->validate([
            'wall_id' => 'required|numeric',
            'fullname' => 'required|max:100',
            'privacy' => 'required',
            'toxicity' => 'required|numeric'
        ]);

        return UserVK::create($storeData);
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
        try {
            $userVK = new GuzzleHttp\Client();
            $res = $userVK->request('GET', Config::get('app.python_host') . '/toxicity_py/api/users/' . $userVK_id);
        } catch (ClientException $e) {
            return  response()->json(['message'=> Psr7\MessWage::toString($e->getResponse())]);
        }
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
        $data = $request->validate([
            'wall_id' => 'required|numeric',
            'fullname' => 'required|max:100',
            'privacy' => 'required',
            'toxicity' => 'required|numeric'
        ]);

        return UserVK::whereId($id)->update($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $userVK = UserVK::findOrFail($id);
        return $userVK->delete();
    }
    public function get_posts($user_id)
    {
        try {
            $post = new GuzzleHttp\Client();
            $res = $post->request('GET', Config::get('app.python_host') . '/toxicity_py/api/posts/' . $user_id);
        } catch (ClientException $e) {
            return  response()->json(['message'=> Psr7\Message::toString($e->getResponse())]);
        }

        return $res->getBody();
    }
    public function get_subscribers($user_id)
    {
        try {
            $subscribers = new GuzzleHttp\Client();
            $res = $subscribers->request('GET', Config::get('app.python_host') . '/toxicity_py/api/followers/'
                . $user_id);
        } catch (ClientException $e) {
            return  response()->json(['message'=> Psr7\Message::toString($e->getResponse())]);
        }

        return $res->getBody();
    }

    public function get_subscriptions($user_id)
    {
        try {
            $subscriptions = new GuzzleHttp\Client();
            $res = $subscriptions->request('GET', Config::get('app.python_host') . '/toxicity_py/api/subscriptions/'
                . $user_id);
        } catch (ClientException $e) {
            return  response()->json(['message'=> Psr7\Message::toString($e->getResponse())]);
        }

        return $res->getBody();
    }

    public function post_message(Request $request)
    {
        try {
            $message = new GuzzleHttp\Client();
            $res = $message->request('POST', Config::get('app.python_host') . '/toxicity_py/api/message',
                ['message' => $request->input('message')]);
        } catch (ClientException $e) {
            return  response()->json(['message'=> Psr7\Message::toString($e->getResponse())]);
        }

        return $res->getBody();
    }

    public function post_messages(Request $request)
    {
        try {
            $messages = new GuzzleHttp\Client();
            $res = $messages->request('POST', Config::get('app.python_host') . '/toxicity_py/api/messages',
                ['messages' => $request->input('messages')]);
        } catch (ClientException $e) {
            return  response()->json(['message'=> Psr7\Message::toString($e->getResponse())]);
        }

        return $res->getBody();
    }
}
