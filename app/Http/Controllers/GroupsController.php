<?php

namespace App\Http\Controllers;

use App\Models\Group;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7;
use Illuminate\Http\Request;
use GuzzleHttp;


class GroupsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Group::all()->toArray();
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
     * @param $group_id
     * @return \Psr\Http\Message\StreamInterface
     * @throws GuzzleHttp\Exception\GuzzleException
     */
    public function show($group_id)
    {
        try {
            $group = new GuzzleHttp\Client();
            $res = $group->request('GET', 'http://'. self::$host . '/toxicity_py/api/groups/' . $group_id);
        } catch (ClientException $e) {
            return  response()->json(['message'=> Psr7\Message::toString($e->getResponse())]);
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

    public function get_posts($group_id)
    {
        try {
            $post = new GuzzleHttp\Client();
            $res = $post->request('GET', 'http://'. self::$host . '/toxicity_py/api/posts/' . $group_id);
        } catch (ClientException $e) {
            return  response()->json(['message'=> Psr7\Message::toString($e->getResponse())]);
        }

        return $res->getBody();
    }

    public function get_members($group_id)
    {
        try {
            $members = new GuzzleHttp\Client();
            $res = $members->request('GET', 'http://'. self::$host . '/toxicity_py/api/members/' . $group_id);
        } catch (ClientException $e) {
            return  response()->json(['message'=> Psr7\Message::toString($e->getResponse())]);
        }

        return $res->getBody();
    }
}
