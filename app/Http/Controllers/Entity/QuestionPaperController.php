<?php

namespace App\Http\Controllers\Entity;

use App\Http\Controllers\Controller;
use App\Models\Question\QuestionPaper;
use App\Http\Requests\StoreQuestionPaperRequest;
use App\Http\Requests\UpdateQuestionPaperRequest;
use App\Models\Quiz\QuizQuestion;
use Illuminate\Http\Request;

class QuestionPaperController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
    * @param  \App\Models\QuestionPaper  $questionPaper
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\QuestionPaper  $questionPaper
     * @return \Illuminate\Http\Response
     */
    public function show(QuestionPaper $questionPaper)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\QuestionPaper  $questionPaper
     * @return \Illuminate\Http\Response
     */
    public function edit(QuestionPaper $questionPaper)
    {
        if(empty($questionPaper) || empty($questionPaper->id)) {
            return back()->with('status', 'Question paper not found');
        }

        $questions = [];
        if($questionPaper->category === 'quiz') {
            $tempQuestions = QuizQuestion::select('question_id', 'name', 'detail', 'question_type')
                ->leftjoin('questions', 'quiz_questions.question_id', '=', 'questions.id')
                ->where('quiz_id', $questionPaper->exam_id)
                ->orderBy('quiz_questions.created_at', 'ASC')
                ->get();
        }

        foreach ($tempQuestions as $ques) {
            $questions[$ques->question_id] = [
                'question' => $ques->detail ? $ques->detail : $ques->name,
                'type' => intval($ques->question_type),
                'id' => intval($ques->question_id),
            ];
        }

        return view('entity.question-paper.edit', [
            'questionPaper' => $questionPaper,
            'questions' => json_encode($questions, JSON_UNESCAPED_UNICODE)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateQuestionPaperRequest  $request
     * @param  \App\Models\QuestionPaper  $questionPaper
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateQuestionPaperRequest $request, QuestionPaper $questionPaper)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\QuestionPaper  $questionPaper
     * @return \Illuminate\Http\Response
     */
    public function destroy(QuestionPaper $questionPaper)
    {
        //
    }
}
