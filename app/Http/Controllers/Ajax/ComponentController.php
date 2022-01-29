<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Question\Question;
use App\Traits\AppResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class ComponentController extends Controller
{
    use AppResponse;

    public function index(Request $request)
    {
        $validateRules = [
            'name' => 'required|string',
        ];

        $validator = Validator::make($request->all(), $validateRules);

        if ($validator->fails()) {

            return $this->response([
                'message' => $validator->errors(),
            ], Response::HTTP_BAD_REQUEST);

        }

        return $this->get($request);
    }

    private function get(Request $request) {
        $viewHtml = '';
        switch ($request->name) {
            case 'question':
                $viewHtml = $this->getQuestionComponent($request);
                break;

            default:
                # code...
                break;
        }

        return $this->response([
            'success' => true,
            'message' => 'Data fetched successfully',
            'data' => [
                'html' => true,
                'content' => $viewHtml
            ],
        ]);
    }

    private function getQuestionComponent(Request $request) {
        switch ($request->type) {
            case 'option':
                $qType = intval($request->value);

                if(in_array($qType, [Question::TYPE_SINGLE, Question::TYPE_MULTIPLE])) {
                    return view('components.form.question-multiple-choice')->with(['type' => $qType])->render();
                } elseif($qType === Question::TYPE_FILL_GAP) {
                    return view('components.form.question-fill-gap')->with([])->render();
                } elseif($qType === Question::TYPE_TEXT_SHORT) {
                    return view('components.form.question-text-answer')->with(['text' => 'short'])->render();
                } elseif($qType === Question::TYPE_TEXT_BROAD) {
                    return view('components.form.question-text-answer')->with(['text' => 'long'])->render();
                } else {
                    return '';
                }
                break;
        }

        return '';
    }
}
