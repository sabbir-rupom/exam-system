<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Question\Question;
use App\Models\Question\QuestionGroup;
use App\Models\Question\QuestionOption;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Traits\ResponseJSON;
use Illuminate\Support\Facades\Validator;

class EntityController extends Controller
{
    use ResponseJSON;

    public function destroy(Request $request)
    {
        $validateRules = [
            'entity' => 'required|string',
            'type' => 'string'
        ];

        $validator = Validator::make($request->all(), $validateRules);

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
                }

                if($request->type === 'option') {
                    $result = QuestionOption::remove($request);
                }

                break;
        }

        return $this->result($result);
    }

    protected function result($data = false) {
        if(is_array($data)) {
            return $this->response([
                'success' => $data['success'],
                'message' => isset($data['message']) ? $data['message'] : '',
            ]);
        }

        return $this->response([
            'success' => true,
            'message' => 'Success',
        ]);
    }

}
