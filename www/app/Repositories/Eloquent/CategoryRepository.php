<?php

namespace App\Repositories\Eloquent;

use App\Models\Category;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use App\Repositories\Contracts\PostRepositoryInterface;
use DB;

class CategoryRepository extends BaseRepository implements CategoryRepositoryInterface
{
    public function model()
    {
        return Category::class;
    }

    public function add($name, $alias, $description)
    {
        return $this->create([
            'name' => $name,
            'alias' => $alias,
            'description' => $description,
        ]);
    }

    public function paginatetCategory($perPage = 20, $columns = array('*'))
    {
        return $this->model->orderBy('id', 'desc')->paginate($perPage, $columns);
    }

    public function delete($id)
    {
        DB::beginTransaction();
        try {
            $this->model->where('alias', '!=', 'chua-phan-loại')->where('id', $id)->delete();
            $post = resolve(PostRepositoryInterface::class);
            $default = $this->getDefaultId();
            $data = [
                "category_id" => $default
            ];
            $post->updatePostAfterDeleteCategory($data, $id);
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
        }
        
    }

    public function findName($name, $columns = array('*')){
        return $this->model->where('name','=',$name)->first();
    }

    public function getDefaultId()
    {
        return $this->findName(config('constants.CATEGORY_DEFAULT'))->id;
    }

}
