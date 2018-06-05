<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\PostRepositoryInterface;
use App\Models\Post;
use Log;
use DB;

class PostRepository extends BaseRepository implements PostRepositoryInterface
{
    public function model() {
        return Post::class;
    }

    public function search($title, $perPage = 20, $columns = array('*')) {
        $title = trim($title);
        if(empty($title)) {
            return $this->model->paginate($perPage, $columns);
        }

        return $this->model
                        ->where('title', $title)
                        ->paginate($perPage, $columns);
    }
}