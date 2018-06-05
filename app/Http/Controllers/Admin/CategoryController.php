<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Repositories\Contracts\CategoryRepositoryInterface as CreateCategoryRepository;
use Illuminate\Http\Request;
use Validator;

class CategoryController extends Controller
{

    /**
     * change email repository
     *
     * @property CategoryRepositoryInterface $categoryName
     */
    private $categoryName;

    public function __construct(CreateCategoryRepository $name)
    {
        $this->categoryName = $name;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $categories = $this->categoryName->paginatetCategory();

        return view('admin.category.listCategory', ['categories' => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\create-category-add
     */
    public function create()
    {
        return view('admin.category.createCategory');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        $name = $request->name;

        $alias = str_slug($name, "-");
        $description = $request->description;
        $data = $this->categoryName->add($name, $alias, $description);
        if ($data) {
            $request->session()->flash('status', 'create category sucessful!');

            return redirect()->route('category.index');
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = $this->categoryName->find($id);

        return view('admin.category.updateCategory', ['categories' => $data]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $category = $this->categoryName->find($id);
       
        if ($category->name == $request->name) {
            $data = [
                'description' => $request->description,
            ];
        } else {
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:255|unique:category,name',
            ]);
            if ($validator->fails()) {

                return redirect()->route('category.edit',$id)->with('errors', $validator->errors())->withInput();
            }

            $data = [
                'name' => $request->name,
                'alias' => str_slug($request->name, "-"),
                'description' => $request->description,
            ];
        }

        $update = $this->categoryName->update($data, $id);
        if ($update) {
            $request->session()->flash('status', 'Update category sucessful!');

            return redirect()->route('category.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($request, $id)
    {

    }

    public function delete(Request $request)
    {
        $id = $request->route('id');
        $categories = $this->categoryName->delete($id);
        if ($categories) {
            $request->session()->flash('status', 'Delete category sucessful! ');

            return redirect()->back();
        }
        
        $request->session()->flash('status', 'category Chưa phân loại not delete');

        return redirect()->route('category.index');
    }
}
