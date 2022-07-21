<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\StorePostsRequest;
use App\Http\Controllers\Controller;
use App\Models\Posts;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Null_;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $posts = Posts::all();
        return response()->json([
            'posts' => $posts
        ]);
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
        $request->validate([
            'title'=>'required',
            'body'=>'required',
            'image'=>'required|file'
        ]);
        // dd($request->file('image'));
        $filename= "";
        if($request->file('image')){
            $filename = $request->file('image')->store('images','public');
        }else{
            $filename = Null;
        }
        $posts = Posts::create([
            'title'=>$request->title,
            'body'=>$request->body,
            'image'=>$filename
        ]);

    return response()->json([
        'message' => "post saved successfully!",
        'posts' => $posts
    ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Posts  $posts
     * @return \Illuminate\Http\Response
     */
    public function show(Posts $posts)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Posts  $posts
     * @return \Illuminate\Http\Response
     */
    public function edit(Posts $posts)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Posts  $posts
     * @return \Illuminate\Http\Response
     */
    public function update(StorePostsRequest $request,  $id)
    {
        //
        $posts = Posts::find($id);
        $posts->update($request->all());

    return response()->json([
        'message' => "post updated successfully!",
        'posts' => $posts
    ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Posts  $posts
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $posts = Posts::find($id);
        $posts->delete();

    return response()->json([
        'status' => true,
        'message' => "post deleted successfully",
    ], 200);
    }
}
