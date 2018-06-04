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

    public function add($name,$alias)
    {
        return $this->create([
            'name' => $name,
            'alias' => $alias
        ]);
    }
}
