<?php

namespace App\Module\TestPaper\Controllers;

use App\Module\BaseAction;
use App\Module\TestPaper\Models\Exam;
use Illuminate\Http\Request;

class ExamController extends BaseAction
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->data['exams'] = Exam::getList($request);
        $this->data['legacy'] = $request->legacy ? true : false;

        return $this->setView('module.test-paper.exam.index')->action();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return $this->setView('module.test-paper.exam.create')->action();
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

        // Category::create([
        //     'name' => trim($request->name),
        //     'detail' => isset($request->detail) ? $request->detail : null,
        //     'code' => trim(strtoupper($request->code)),
        // ]);

        return redirect()->route('entity.category.index')->with('success', 'Category added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Module\CourseCatalogue\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Exam $exam)
    {
        return $this->edit($exam);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Module\TestPaper\Models\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function edit(Exam $exam)
    {
        if (empty($exam) || empty($exam->id)) {
            return back()->with('status', 'Exam not found');
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Module\TestPaper\Models\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Exam $exam)
    {


        return back()->with('success', 'Exam updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Module\TestPaper\Models\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function destroy(Exam $exam)
    {


        return back()->with('success', 'Exam deleted successfully');
    }

}
