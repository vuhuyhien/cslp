<?php

namespace App\Repositories\Eloquent;

use App\Models\Category;
use App\Repositories\Contracts\CreateCategoryRepositoryInterface;

class CategoryRepository extends BaseRepository implements CreateCategoryRepositoryInterface
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
        return $this->model->where('alias', '!=', 'chua-phan-loại')->where('id', $id)->delete();
    }

    // public function findName($name, $columns = array('*'))
    // {
    //     return $this->model->where('name', '=', $name)->get();
    // }
}
