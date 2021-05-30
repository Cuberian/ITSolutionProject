<?php

namespace App\Http\Controllers;

use App\Models\Group;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7;
use Illuminate\Http\Request;
use GuzzleHttp;
use Illuminate\Support\Facades\Config;


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
        $storeData = $request->validate([
            'wall_id' => 'required|numeric',
            'info'=> 'required|max:255',
            'privacy' => 'required',
            'toxicity' => 'required|numeric'
        ]);

        return response(Group::create($storeData));
    }

    /**
     * Display the specified resource.
     *
     * @param $group_id
     * @return \Illuminate\Http\JsonResponse
     * @throws GuzzleHttp\Exception\GuzzleException
     */
    public function show($group_id)
    {
        try {
            $group = new GuzzleHttp\Client();
            $res = $group->request('GET', Config::get('app.python_host') . '/toxicity_py/api/groups/' . $group_id);
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
        $data = $request->validate([
            'wall_id' => 'required|numeric',
            'info'=> 'required|max:255',
            'privacy' => 'required',
            'toxicity' => 'required|numeric'
        ]);

        return Group::where('id',$id)->update($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $group = Group::findOrFail($id);
        return $group->delete();
    }

    public function get_posts($group_id)
    {
        $group = Group::find($group_id);
        $posts = $group->posts;
        return response()->json($posts);
    }


    public function get_members($group_id)
    {
        try {
            $members = new GuzzleHttp\Client();
            $res = $members->request('GET', Config::get('app.python_host') . '/toxicity_py/api/members/' . $group_id);
        } catch (ClientException $e) {
            return  response()->json(['message'=> Psr7\Message::toString($e->getResponse())]);
        }

        return $res->getBody();
    }
}
