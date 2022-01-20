<?php

namespace App\Http\Controllers\Entity;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\Question\Question;
use App\Models\Question\QuestionPaper;
use App\Models\Question\QuestionType;
use App\Models\Quiz\Quiz;
use App\Models\Quiz\QuizQuestion;
use Carbon\Carbon;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $quizzes = Quiz::where('owner_id', session('owner')['id'])->paginate(10);

        return view('entity.quiz.index', [
            'quizzes' => $quizzes,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $questions = Question::select('id', 'name')
            ->whereIn('question_type', array_keys(Question::EXAM_QUIZ))
            ->where('owner_id', session('owner')['id'])->orderBy("name")->get();

        $groups = Group::where('owner_id', session('owner')['id'])->get();
        $questionTypes = QuestionType::getTypes('quiz');

        return view('entity.quiz.create', [
            'questions' => $questions,
            'groups' => $groups,
            'questionTypes' => $questionTypes,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->_validateRequests($request);


        if (count($request->questions) < $request->question_amount) {
            return back()->with('status', __('alert.insufficient_questions_provided'));
        }

        $quiz = Quiz::addOrSave($request, null);

        if(isset($request->question_paper) && $request->question_paper) {
            $qPaper = QuestionPaper::init($quiz);

            return redirect()->route('question-papers.edit', ['question_paper' => $qPaper]);
        }

        return redirect()->route('quizzes.index')->with('success', __('alert.created_successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Quiz\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function show(Quiz $quiz)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Quiz\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function edit(Quiz $quiz)
    {
        if (empty($quiz) || $quiz->owner_id != session('owner')['id']) {
            return back()->with('status', __('alert.quiz_not_found'));
        }

        $questions = Question::select('id', 'name')
            ->whereIn('question_type', array_keys(Question::EXAM_QUIZ))
            ->where('owner_id', session('owner')['id'])->orderBy("name")->get();

        $groups = Group::where('owner_id', session('owner')['id'])->get();
        $questionTypes = QuestionType::getTypes('quiz');

        $quizQuestions = QuizQuestion::getQuestions($quiz->id);

        return view('entity.quiz.edit', [
            'quiz' => $quiz,
            'questions' => $questions,
            'quizQuestions' => $quizQuestions,
            'groups' => $groups,
            'questionTypes' => $questionTypes,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Quiz\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Quiz $quiz)
    {
        if (empty($quiz) || $quiz->owner_id != session('owner')['id']) {
            return back()->with('status', __('alert.quiz_not_found'));
        }

        $quiz = Quiz::addOrSave($request, $quiz);

        if(isset($request->question_paper) && $request->question_paper) {
            $qPaper = QuestionPaper::init($quiz);

            return redirect()->route('question-papers.edit', ['questionPaper' => $qPaper]);
        }

        return back()->with('success', __('alert.updated_successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Quiz\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function destroy(Quiz $quiz)
    {
        if (empty($quiz) || $quiz->owner_id != session('owner')['id']) {
            return back()->with('status', __('alert.quiz_not_found'));
        }

        $quiz->delete();

        return redirect()->route('quizzes.index')
            ->with('success', __('alert.deleted_successfully'));
    }

    /**
     * Validate quiz save requests
     *
     * @param Request $request
     * @return void
     */
    private function _validateRequests(Request $request)
    {
        $validationRules = [
            'name' => 'required|string',
            'duration' => 'required|integer|min:1|max:200',
            'question_amount' => 'required|integer|min:2|max:100',
            'pass_mark' => 'required|integer|min:0|max:100',
            'questions' => 'required|array|min:2',
            'questions.*' => 'required|integer',
        ];

        $this->validate($request, $validationRules);
    }
}
