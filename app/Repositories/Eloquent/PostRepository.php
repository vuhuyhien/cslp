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
}