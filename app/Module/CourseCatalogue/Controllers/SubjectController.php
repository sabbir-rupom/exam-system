<?php

namespace App\Module\CourseCatalogue\Controllers;

use App\Module\BaseAction;
use App\Module\CourseCatalogue\Models\Category;
use App\Module\CourseCatalogue\Models\CategoryClass;
use App\Module\CourseCatalogue\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends BaseAction
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $select = [
            'subjects.id', 'subjects.name as subject_name', 'subjects.code as subject_code',
            'category_classes.name as class_name', 'category_classes.code as class_code',
            'categories.name as category_name', 'categories.code as category_code',
        ];
        $this->data['subjects'] = Subject::select($select)
            ->join('category_classes', 'category_classes.id', '=', 'subjects.category_class_id')
            ->join('categories', 'categories.id', '=', 'category_classes.category_id')
            ->paginate(10);

        return $this->setView('module.course-catalogue.subject.index')->action();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->data['categories'] = Category::select('id', 'name', 'code')->orderBy('name', 'ASC')->get();
        $this->data['classData'] = json_encode(CategoryClass::classByCategory(false, true));

        return $this->setView('module.course-catalogue.subject.create')->action();
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
            'code' => 'required|unique:subjects,code',
            'class_id' => 'required|exists:category_classes,id'
        ]);

        Subject::create([
            'name' => $request->name,
            'category_class_id' => $request->class_id,
            'code' => $request->code,
        ]);

        return redirect()->route('entity.subject.index')->with('success', 'Subject added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Module\CourseCatalogue\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function show(Subject $subject)
    {
        return $this->edit($subject);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Module\CourseCatalogue\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function edit(Subject $subject)
    {
        if (empty($subject) || empty($subject->id)) {
            return back()->with('status', 'Subject not found');
        }

        $this->data['subject'] = $subject;
        $this->data['categories'] = Category::select('id', 'name', 'code')->orderBy('name', 'ASC')->get();

        $this->data['class'] = CategoryClass::where('id', $subject->category_class_id)->first();

        $this->data['classData'] = json_encode(CategoryClass::classByCategory(false, true));

        return $this->setView('module.course-catalogue.subject.edit')->action();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Module\CourseCatalogue\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subject $subject)
    {
        if (empty($subject) || empty($subject->id)) {
            return back()->with('status', 'Subject not found');
        }

        $this->validate($request, [
            'name' => 'required|min:3|max:150',
            'code' => 'required',
            'class_id' => 'required|exists:category_classes,id'
        ]);

        $code = trim(strtoupper($request->code));

        if($code !== trim(strtoupper($subject->code)) && Subject::where('code', $code)->exists()) {
            return back()->with('status', 'Subject code already exists');
        }

        $subject->name = $request->name;
        $subject->code = $request->code;
        $subject->category_class_id = $request->class_id;
        $subject->save();

        return back()->with('success', 'Subject updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Module\CourseCatalogue\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subject $subject)
    {
        if (empty($subject) || empty($subject->id)) {
            return back()->with('status', 'Subject not found');
        }

        $subject->delete();

        return back()->with('success', 'Subject deleted successfully');
    }

}
