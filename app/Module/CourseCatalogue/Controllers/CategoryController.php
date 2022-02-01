<?php

namespace App\Module\CourseCatalogue\Controllers;

use App\Module\BaseAction;
use App\Module\CourseCatalogue\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends BaseAction
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->data['categories'] = Category::select('id', 'name', 'code')->paginate(10);

        return $this->setView('module.course-catalogue.category.index')->action();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return $this->setView('module.course-catalogue.category.create')->action();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:3|max:150',
            'code' => 'required|unique:categories,code',
        ]);

        Category::create([
            'name' => trim($request->name),
            'detail' => isset($request->detail) ? $request->detail : null,
            'code' => trim(strtoupper($request->code)),
        ]);

        return redirect()->route('entity.category.index')->with('success', 'Category added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Module\CourseCatalogue\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return $this->edit($category);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Module\CourseCatalogue\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        if (empty($category) || empty($category->id)) {
            return back()->with('status', 'Category not found');
        }
        $this->data['category'] = $category;
        return $this->setView('module.course-catalogue.category.edit')->action();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Module\CourseCatalogue\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        if (empty($category) || empty($category->id)) {
            return back()->with('status', 'Category not found');
        }

        $this->validate($request, [
            'name' => 'required|min:3|max:150',
            'code' => 'required',
        ]);

        $code = trim(strtoupper($request->code));

        if($code !== $category->code && Category::where('code', $code)->exists()) {
            return back()->with('status', 'Category code already exists');
        }

        $category->name = trim($request->name);
        $category->code = $code;
        $category->detail = $request->detail;
        $category->save();

        return back()->with('success', 'Category updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Module\CourseCatalogue\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        if (empty($category) || empty($category->id)) {
            return back()->with('status', 'Category not found');
        }

        $category->delete();

        return back()->with('success', 'Category deleted successfully');
    }

}
