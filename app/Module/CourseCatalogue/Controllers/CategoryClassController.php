<?php

namespace App\Module\CourseCatalogue\Controllers;

use App\Module\BaseAction;
use App\Module\CourseCatalogue\Models\Category;
use App\Module\CourseCatalogue\Models\CategoryClass;
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
        $select = [
            'category_classes.id', 'category_classes.name as class_name', 'category_classes.code as class_code',
            'categories.name as category_name', 'categories.code as category_code',
        ];
        $this->data['classes'] = CategoryClass::select($select)
            ->join('categories', 'categories.id', '=', 'category_classes.category_id')
            ->paginate(10);

        return $this->setView('module.course-catalogue.class.index')->action();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->data['categories'] = Category::select('id', 'name', 'code')->orderBy('name', 'ASC')->get();

        return $this->setView('module.course-catalogue.class.create')->action();
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
            'code' => 'required|unique:category_classes,code',
            'category_id' => 'required|exists:categories,id'
        ]);

        CategoryClass::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'code' => $request->code,
        ]);

        return redirect()->route('entity.category-class.index')->with('success', 'Class added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Module\CourseCatalogue\Models\CategoryClass  $categoryClass
     * @return \Illuminate\Http\Response
     */
    public function show(CategoryClass $categoryClass)
    {
        return $this->edit($categoryClass);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Module\CourseCatalogue\Models\CategoryClass  $categoryClass
     * @return \Illuminate\Http\Response
     */
    public function edit(CategoryClass $categoryClass)
    {
        if (empty($categoryClass) || empty($categoryClass->id)) {
            return back()->with('status', 'Class not found');
        }
        $this->data['class'] = $categoryClass;
        $this->data['categories'] = Category::select('id', 'name', 'code')->orderBy('name', 'ASC')->get();

        return $this->setView('module.course-catalogue.class.edit')->action();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Module\CourseCatalogue\Models\CategoryClass  $categoryClass
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CategoryClass $categoryClass)
    {
        if (empty($categoryClass) || empty($categoryClass->id)) {
            return back()->with('status', 'Class not found');
        }

        $this->validate($request, [
            'name' => 'required|min:3|max:150',
            'code' => 'required|unique:category_classes,code',
            'category_id' => 'required|exists:categories,id'
        ]);

        $categoryClass->name = $request->name;
        $categoryClass->code = $request->code;
        $categoryClass->category_id = $request->category_id;
        $categoryClass->save();

        return back()->with('success', 'Class updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Module\CourseCatalogue\Models\CategoryClass  $categoryClass
     * @return \Illuminate\Http\Response
     */
    public function destroy(CategoryClass $categoryClass)
    {
        if (empty($categoryClass) || empty($categoryClass->id)) {
            return back()->with('status', 'Class not found');
        }

        $categoryClass->delete();

        return back()->with('success', 'Class deleted successfully');
    }

}
