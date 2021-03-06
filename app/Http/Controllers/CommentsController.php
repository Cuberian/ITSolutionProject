<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use GuzzleHttp;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Config;

class CommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return array
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
        $storeData = $request->validate([
            'post_id' => 'required|numeric',
            'author_id' => 'required|numeric',
            'author_type' => 'required|max:50',
            'text' => 'required|max:255',
            'toxicity' => 'required|numeric'
        ]);
        return Comment::create($storeData);
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
        $data = $request->validate([
            'post_id' => 'required|numeric',
            'author_id' => 'required|numeric',
            'author_type' => 'required|max:50',
            'text' => 'required|max:255',
            'toxicity' => 'required|numeric'
        ]);

        return Comment::whereId($id)->update($data);;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        return $comment->delete();
    }

    public function get_comment($user_id, $post_id)
    {
        $comment = new GuzzleHttp\Client();
        try {
            $res = $comment->request('GET', Config::get('app.python_host'). '/toxicity_py/api/comments/'
                . $user_id . '/' . $post_id);
        } catch (ClientException $e) {
           return  response()->json(['message'=> Psr7\Message::toString($e->getResponse())]);
        }
        return $res->getBody();
    }

    public function get_answer($user_id, $comment_id)
    {
        try {
            $comment = new GuzzleHttp\Client();
            $res = $comment->request('GET', Config::get('app.python_host') . '/toxicity_py/api/answers/'
                . $user_id . '/' . $comment_id);
        } catch (ClientException $e) {
            return  response()->json(['message'=> Psr7\Message::toString($e->getResponse())]);
        }

        return $res->getBody();
    }
}
