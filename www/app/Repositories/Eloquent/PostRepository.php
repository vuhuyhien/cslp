<?php

namespace App\Repositories\Eloquent;

use App\Models\Post;
use App\Repositories\Contracts\PostRepositoryInterface;

class PostRepository extends BaseRepository implements PostRepositoryInterface
{
    public function model()
    {
        return Post::class;
    }

    public function search($conditions, $perPage = 20, $columns = array('*'))
    {
        $result = $this->model->whereRaw('1=1');
        foreach($conditions as $key => $condition) {
            switch($key) {
                case 'category':
                    $result->where($key, $condition);
                    break;
                case 'title':
                    $condition = trim($condition);
                    $result->where($key, 'like',  '%' . $condition . '%');
                    break;
                default:
                    $result->where($key, $condition);
                    break;
            }
        }

        return $result->orderBy('created_at', 'desc')->paginate($perPage, $columns);
    }


    public function updatePostAfterDeleteCategory(array $data, $category_id, $attribute = "category_id")
    {
        return $this->model->where($attribute, '=', $category_id)->update($data);
    }
}
