<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Question\Question;
use App\Models\Question\QuestionGroup;
use App\Models\Question\QuestionOption;
use App\Traits\AppResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class EntityController extends Controller
{
    use AppResponse;

    public function create(Request $request) {
        if(empty($request->entity) || empty($request->type)) {
            return $this->response([
                'message' => 'Invalid request parameters',
            ], Response::HTTP_BAD_REQUEST);
        }

        $validator = Validator::make($request->all(), $this->_prepareValidateRules($request, 'create'));

        if ($validator->fails()) {

            return $this->response([
                'message' => $validator->errors(),
            ], Response::HTTP_BAD_REQUEST);

        }

        $result = false;

        switch ($request->entity) {
            case 'question':

                if($request->type === 'group') {
                    // $result = QuestionGroup::add($request);
                } else {

                    $result = Question::add($request);
                }

                break;
        }

        return $this->result($result);
    }

    public function destroy(Request $request)
    {

        $validator = Validator::make($request->all(), $this->_prepareValidateRules($request, 'delete'));

        if ($validator->fails()) {

            return $this->response([
                'message' => $validator->errors(),
            ], Response::HTTP_BAD_REQUEST);
        }

        $result = false;

        switch ($request->entity) {
            case 'question':

                if($request->type === 'group') {
                    $result = QuestionGroup::remove($request);
                } elseif($request->type === 'option') {
                    $result = QuestionOption::remove($request);
                } else {

                }

                break;
        }

        return $this->result($result);
    }


    private function _prepareValidateRules(Request $request, string $type) {
        $validateRules = [
            'entity' => 'required|string',
            'type' => 'string'
        ];

        if($type === 'delete') {
            return $validateRules;
        }

        switch ($request->entity) {
            case 'question':

                if($request->type === 'group') {

                } elseif($request->type === 'option') {

                } else {
                    $validationRules['question_type'] = 'required|integer';
                    $validationRules['name'] = 'required|string';

                    if(in_array($request->question_type, [Question::TYPE_SINGLE, Question::TYPE_MULTIPLE, Question::TYPE_FILL_GAP])) {
                        $validationRules['option'] = 'required|array|min:1';

                        if($request->question_type != Question::TYPE_FILL_GAP) {
                            $validationRules['answer'] = 'required|array|min:1';
                        }
                    }

                    if (!empty($request->detail)) {
                        $validationRules['detail'] = 'required|max:5000000';
                    }
                }

                break;
        }

        return $validateRules;
    }

    protected function result($data = false) {
        if(is_array($data)) {
            return $this->response([
                'success' => isset($data['success']) ? $data['success'] : false,
                'message' => isset($data['message']) ? $data['message'] : '',
                'data' => isset($data['data']) ? $data['data'] : []
            ]);
        }

        return $this->response([
            'success' => true,
            'message' => 'Success',
        ]);
    }

}
