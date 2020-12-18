<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use GuzzleHttp;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class CommentsController extends Controller
{
    public static $host = 'project';
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
        //возвращаем все комментарии по запросу /toxicity/comments
        return Comment::all()->toArray();
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
