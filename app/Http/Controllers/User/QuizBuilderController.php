<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use Carbon\Carbon;
use Illuminate\Http\Request;

class QuizBuilderController extends Controller
{
    /**
     * Quiz list page
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function index(Request $request)
    {
        $quiz = new Quiz();

        $quizzes = $quiz->where('user_id', auth()->user()->id)->paginate(10);

        return view('user.quiz.builder.index', [
            'quizzes' => $quizzes,
        ]);
    }

    /**
     * Quiz create form page
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function create()
    {

        $questions = Question::select('id', 'name')
            ->where('user_id', auth()->user()->id)->orderBy("name")->get();

        return view('user.quiz.builder.create', [
            'questions' => $questions,
        ]);
    }

    /**
     * Process form data & create new Quiz
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {

        $this->_validateRequests($request);


        if (count($request->questions) < $request->question_amount) {
            return back()->with('status', __('alert.insufficient_questions_provided'));
        }

        $status = isset($request->status) && intval($request->status) > 0 ? 1 : 0;

        $quiz = Quiz::create([
            'user_id' => auth()->user()->id,
            'name' => $request->name,
            'duration' => $request->duration,
            'question_amount' => $request->question_amount,
            'pass_mark' => $request->pass_mark,
            'status' => $status,
        ]);

        $i = 1;
        $insertData = [];
        foreach ($request->questions as $qid) {
            $insertData[] = [
                'question_id' => $qid,
                'quiz_id' => $quiz->id,
                'sequence' => $i++,
                'created_at' => Carbon::now(),
            ];
        }
        QuizQuestion::insert($insertData);

        return back()->with('success', __('alert.created_successfully'));
    }

    /**
     * Quiz edit form page
     *
     * @param Quiz $quiz
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function edit(Quiz $quiz)
    {
        if (empty($quiz) || $quiz->user_id != auth()->user()->id) {
            return back()->with('status', __('alert.quiz_not_found'));
        }

        $questions = Question::select('id', 'name')
            ->where('user_id', auth()->user()->id)->orderBy("name")->get();

        $quizQuestions = QuizQuestion::getQuestions($quiz->id);

        return view('user.quiz.builder.edit', [
            'quiz' => $quiz,
            'questions' => $questions,
            'quizQuestions' => $quizQuestions,
        ]);
    }

    /**
     * Process form data and update quiz
     *
     * @param Request $request
     * @param Quiz $quiz
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Quiz $quiz)
    {
        if (empty($quiz) || $quiz->user_id != auth()->user()->id) {
            return back()->with('status', __('alert.quiz_not_found'));
        }

        $status = isset($request->status) && intval($request->status) > 0 ? 1 : 0;

        $quiz->update([
            'name' => $request->name,
            'duration' => $request->duration,
            'question_amount' => $request->question_amount,
            'pass_mark' => $request->pass_mark,
            'status' => $status,
        ]);

        $quizQuestion = new QuizQuestion();

        $quizQuestion->where('quiz_id', $quiz->id)->delete();

        $i = 1;
        $insertData = [];
        foreach ($request->questions as $qid) {
            $insertData[] = [
                'question_id' => $qid,
                'quiz_id' => $quiz->id,
                'sequence' => $i++,
                'created_at' => Carbon::now(),
            ];
        }
        QuizQuestion::insert($insertData);

        return back()->with('success', __('alert.updated_successfully'));
    }

    /**
     * Delete Quiz
     *
     * @param Quiz $quiz
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove(Quiz $quiz)
    {
        if (empty($quiz) || $quiz->user_id != auth()->user()->id) {
            return back()->with('status', __('alert.quiz_not_found'));
        }

        $quiz->delete();

        return redirect('/quiz/list')
            ->with('success', __('alert.deleted_successfully'));
    }

    /**
     * Validate form requests
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
