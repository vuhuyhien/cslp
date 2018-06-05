<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Contracts\PostRepositoryInterface as Posts;
use Log;

class PostController extends Controller
{
    private $posts;

    public function __construct(Posts $posts)
    {
        $this->posts = $posts;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = request()->get('title');
        $posts = $this->posts->search($title);

        return view('admin.post.index')->with("posts", $posts)->with('title', $title);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.post.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(\App\Http\Requests\CreatePost $request)
    {
        $data = $request->all();
        Log::info("create post with data: " . print_r($data, true));
        if( $request->hasFile('image')) {
            $data["image"] = $request->file('image')->store('image');
        }

        if($this->posts->create($data)) {
            Log::info("create successful");
            $request->session()->flash('status', 'Create post sucessful!');

            return redirect()->route('posts.index');
        } else {
            Log::info("create fail");
            $request->session()->flash('status', 'Create post fail!');

            return redirect()->route('posts.create')->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = $this->posts->find($id);
        if(!$post) {
            abort(404);
        }

        return view('admin.post.edit')->with('post', $post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(\App\Http\Requests\CreatePost $request, $id)
    {
        $data = $request->only(
            'title',
            'image',
            'intro',
            'content',
            'type'
        );
        Log::info("update post with data: " . print_r($data, true));
        if( $request->hasFile('image')) {
            $data["image"] = $request->file('image')->store('image');
        }

        if(!isset($data['type'])) {
            $data['type'] = 0;
        }

        if($this->posts->update($data, $id)) {
            Log::info("update successful");
            $request->session()->flash('status', 'Update post sucessful!');

            return redirect()->route('posts.index');
        } else {
            Log::info("update fail");
            $request->session()->flash('status', 'Update post fail!');

            return redirect()->route('posts.update')->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->posts->delete($id);

        return redirect()->back();
    }
}
