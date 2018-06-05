<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\CreateCategoryRepositoryInterface as Category;
use App\Repositories\Contracts\PostRepositoryInterface as Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    private $post;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Post $post, Category $category)
    {
        $this->post = $post;
        $this->category = $category;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $title = $request->get('title');
        $category = trim($request->get('category'));
        $data=[];
        if ($category) {
            $idCategory = $this->category->findBy('alias', $category)->id;
            $data = [
                'category_id' => $idCategory,
            ];
        }

        if ($title) {
            $data = [
                'title' => $title,
            ];
        }

        if ($title && $category) {
            $idCategory = $this->category->findBy('alias', $category)->id;
            $data = [
                'title' => $title,
                'category_id' => $idCategory,
            ];
        }

        $user = resolve('App\Repositories\Contracts\UserRepositoryInterface');
        $author = $user->getAuthor();
        $posts = $this->post->search($data);
        $category = $this->category->all();
        return view('home')->with('posts', $posts)->with('author', $author)->with("title", $title)->with("category", $category);
    }

    public function viewPost($postId)
    {
        $post = $this->post->find($postId);
        $user = resolve('App\Repositories\Contracts\UserRepositoryInterface');
        $author = $user->getAuthor();
        $category = $this->category->all();
        if ($post) {
            return view('view')->with('post', $post)->with('author', $author)->with("category", $category);
        }

        abort(404);
    }
}
