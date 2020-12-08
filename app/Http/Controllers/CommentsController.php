<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp;
class CommentsController extends Controller
{
    public static $host = 'project';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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

    public function get_comment($user_id, $post_id)
    {
        $comment = new GuzzleHttp\Client();
        $res = $comment->request('GET', 'http://'. self::$host . '/toxicity_py/api/comments/'
            . $user_id . '/' . $post_id);
        return $res->getBody();
    }

    public function get_answer($user_id, $comment_id)
    {
        $comment = new GuzzleHttp\Client();
        $res = $comment->request('GET', 'http://'. self::$host . '/toxicity_py/api/answers/'
            . $user_id . '/' . $comment_id);
        return $res->getBody();
    }
}
