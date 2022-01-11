<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\QuestionOption;
use App\Models\QuestionType;
use App\Models\QuizAnswer;
use App\Models\QuizQuestion;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * Show list of owned questions
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     * */
    public function index(Request $request)
    {

        $questions = Question::questionList($request);

        $questionTypes = QuestionType::getTypes();

        return view('user.question.index', [
            'questions' => $questions,
            'questionTypes' => $questionTypes,
        ]);
    }

    /**
     * Show question create form
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     * */
    public function create()
    {
        $questionTypes = QuestionType::getTypes();
        return view('user.question.create', [
            'questionTypes' => $questionTypes,
        ]);

    }

    /**
     * Create new question from post submit
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {

        $this->_requestValidate($request);

        $question = Question::create([
            'user_id' => auth()->user()->id,
            'name' => $request->name,
            'detail' => !empty($request->detail) ? $request->detail : null,
            'difficulty' => $request->difficulty,
            'explanation' => !empty($request->explanation) ? $request->explanation : null,
            'question_type' => $request->question_type,
            'category' => Question::CAT_GENERAL,
            'status' => 1,
        ]);

        QuestionOption::addNew($request, $question->id);

        return back()->with('success', __('alert.question_added_successfully'));
    }

    private function _requestValidate(Request $request)
    {
        $validationRules = [
            'question_type' => 'required|integer',
            'difficulty' => 'required|integer',
            'name' => 'required|string',
        ];

        $validationRules['option'] = 'required|array|min:1';
        if (!empty($request->detail)) {
            $validationRules['detail'] = 'required|max:5000000';
        }

        if (!empty($request->course_id)) {
            $validationRules['course_id'] = 'required|integer';
        }
        if (!empty($request->is_answer)) {
            $validationRules['is_answer'] = 'required|array|min:1';
        }
        if (!empty($request->explanation)) {
            $validationRules['explanation'] = 'max:5000000';
        }

        $this->validate($request, $validationRules);
    }

    /**
     * Question edit form page
     *
     * @param Question $question
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function edit(Question $question)
    {
        if (empty($question)) {
            return back()->with('status', __('alert.question_not_found'));
        }

        $questionTypes = QuestionType::getTypes();
        $options = QuestionOption::getOptions($question->id);

        return view('user.question.edit', [
            'ques' => $question,
            'questionTypes' => $questionTypes,
            'options' => $options,
        ]);
    }

    /**
     * Update specific question if owned
     *
     * @param Request $request
     * @param Question $event
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Question $question)
    {
        if (empty($question)) {
            return back()->with('status', __('alert.question_not_found'));
        }

        $this->_requestValidate($request);


        if (auth()->user()->id != $question->user_id) {
            return back()->with('status', __('alert.question_ownership_mismatched'));
        }

        $question->question_type = $request->question_type;
        $question->category = !empty($request->is_course) ? 1 : 0;
        $question->difficulty = $request->difficulty;
        $question->name = $request->name;
        $question->detail = !empty($request->detail) ? $request->detail : null;
        $question->explanation = !empty($request->explanation) ? $request->explanation : null;
        $question->save();

        QuestionOption::updateAll($request, $question->id);

        return back()->with('success', __('alert.question_updated_successfully'));
    }

    /**
     * Delete a question if not in use
     *
     * @param Question $event
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove(Question $question)
    {
        if (empty($question->id)) {
            return back()->with('status', __('alert.question_not_found'));
        }
        if (QuizAnswer::where('question_id', $question->id)->exists()) {
            return back()->with('status', __('alert.question_cannot_deleted'));
        }

        if($question->user_id != auth()->user()->id || !session('role_admin')) {
            return back()->with('status', __('alert.question_ownership_mismatched'));

        }

        QuestionOption::where('question_id', $question->id)->delete();
        QuizQuestion::where('question_id', $question->id)->delete();

        $question->delete();

        return back()->with('success', __('alert.question_deleted_successfully'));
    }
}
