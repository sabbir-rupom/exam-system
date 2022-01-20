<?php

namespace App\Http\Controllers\Entity;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\Question\Question;
use App\Models\Question\QuestionGroup;
use App\Models\Question\QuestionOption;
use App\Models\Question\QuestionType;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $filters = [];

        if ($request->group > 0) {
            $filters['group_id'] = intval($request->group);
        }

        if(session('is_owner')) {
            $filters['questions.owner_id'] = session('owner')['id'];
        }

        $questions = Question::questionList($filters);

        $questionTypes = QuestionType::getTypes();

        return view('entity.question.index', [
            'questions' => $questions,
            'questionTypes' => $questionTypes,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $questionTypes = QuestionType::getTypes();
        $groups = Group::where('owner_id', session('owner')['id'])->get();
        return view('entity.question.create', [
            'questionTypes' => $questionTypes,
            'groups' => $groups
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
        $this->_requestValidate($request);

        Question::add($request);

        return back()->with('success', __('alert.question_added_successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Question\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Question\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question)
    {
        if (empty($question)) {
            return back()->with('status', __('alert.question_not_found'));
        }

        $questionTypes = QuestionType::getTypes();
        $options = QuestionOption::getOptions($question->id);
        $groups = Group::where('owner_id', session('owner')['id'])->get();

        return view('entity.question.edit', [
            'ques' => $question,
            'questionTypes' => $questionTypes,
            'options' => $options,
            'groups' => $groups
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Question\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Question $question)
    {
        if (empty($question)) {
            return back()->with('status', __('alert.question_not_found'));
        }

        $this->_requestValidate($request);

        if (session('owner')['id'] != $question->owner_id) {
            return back()->with('status', __('alert.question_ownership_mismatched'));
        }

        $question->question_type = $request->question_type;
        $question->difficulty = $request->difficulty;
        $question->name = $request->name;
        $question->detail = !empty($request->detail) ? $request->detail : null;
        $question->explanation = !empty($request->explanation) ? $request->explanation : null;
        $question->save();

        if($request->group && $request->group > 0) {
            $qGroup = QuestionGroup::firstOrNew([
                'group_id' => intval($request->group),
                'question_id' => $question->id
            ]);
            $qGroup->save();

        }

        QuestionOption::updateAll($request, $question->id);

        return back()->with('success', __('alert.question_updated_successfully'));
    }

    /**
     * Form submit data validation
     *
     * @param Request $request
     * @return void
     */
    private function _requestValidate(Request $request)
    {
        $validationRules = [
            'question_type' => 'required|integer',
            'difficulty' => 'required|integer',
            'name' => 'required|string',
        ];

        if(in_array($request->question_type, [Question::TYPE_SINGLE, Question::TYPE_MULTIPLE, Question::TYPE_FILL_GAP])) {
            $validationRules['option'] = 'required|array|min:1';

            if($request->question_type != Question::TYPE_FILL_GAP) {
                $validationRules['answer'] = 'required|array|min:1';
            }
        }

        if (!empty($request->detail)) {
            $validationRules['detail'] = 'required|max:5000000';
        }

        if (!empty($request->explanation)) {
            $validationRules['explanation'] = 'max:5000000';
        }

        $this->validate($request, $validationRules);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Question\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
        if (empty($question->id)) {
            return back()->with('status', __('alert.question_not_found'));
        }
        // if (QuizAnswer::where('question_id', $question->id)->exists()) {
        //     return back()->with('status', __('alert.question_cannot_deleted'));
        // }

        if (session('owner')['id'] != $question->owner_id) {
            return back()->with('status', __('alert.question_ownership_mismatched'));

        }

        QuestionOption::where('question_id', $question->id)->delete();
        // QuizQuestion::where('question_id', $question->id)->delete();

        $question->delete();

        return back()->with('success', __('alert.question_deleted_successfully'));
    }
}
