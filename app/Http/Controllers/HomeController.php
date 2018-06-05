<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Contracts\PostRepositoryInterface as Post;

class HomeController extends Controller
{
    private $post;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $title = $request->get('title');
        $user = resolve('App\Repositories\Contracts\UserRepositoryInterface');
        $author = $user->getAuthor();
        $posts = $this->post->search($title);

        return view('home')->with('posts', $posts)->with('author', $author)->with("title", $title);
    }

    public function viewPost($postId)
    {
        $post = $this->post->find($postId);
        $user = resolve('App\Repositories\Contracts\UserRepositoryInterface');
        $author = $user->getAuthor();
        if($post) {
            return view('view')->with('post', $post)->with('author', $author);
        }

        abort(404);
    }
}
