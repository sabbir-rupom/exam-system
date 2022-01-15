<?php

namespace App\Models\Question;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuestionOption extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'content',
        'answer',
        'question_id',
    ];

    /**
     * Get Option Data Saved under A Question
     *
     * @param integer $questionId
     * @return array
     */
    public static function getOptions(int $questionId): array
    {
        $queryResult = self::where('question_id', $questionId)->get();

        $dataResult = [];

        if ($queryResult->isEmpty()) {
            return $dataResult;
        }

        foreach ($queryResult as $data) {
            $dataResult[] = [
                'id' => $data->id,
                'content' => $data->content,
                'answer' => $data->answer > 0 ? 1 : 0,
            ];
        }

        return $dataResult;
    }

    /**
     * Insert new options under a question
     *
     * @param Request $request
     * @param integer $questionId
     * @return void
     */
    public static function addNew(Request $request, int $questionId)
    {
        if (in_array($request->question_type, [Question::TYPE_SINGLE, Question::TYPE_MULTIPLE, Question::TYPE_FILL_GAP])) {
            foreach ($request->option as $k => $val) {
                if (empty($val)) {
                    continue;
                }
                QuestionOption::create([
                    'content' => $val,
                    'answer' => ($request->question_type != Question::TYPE_FILL_GAP) ? (isset($request->answer[$k]) && !empty($request->answer[$k]) ? 1 : 0) : 1,
                    'question_id' => $questionId,
                ]);
            }
        }

        return;
    }

    /**
     * Update options under a question
     *
     * @param Request $request
     * @param integer $questionId
     * @return void
     */
    public static function updateAll(Request $request, int $questionId)
    {
        // $options = self::where('question_id', $questionId)->get();

        foreach ($request->option as $k => $val) {
            if (empty($val)) {
                continue;
            }
            if (strpos($k, '_')) {
                $temp = explode('_', $k);
                $id = isset($temp[1]) ? intval($temp[1]) : 0;

                $option = self::where([
                    'question_id' => $questionId,
                    'id' => $id,
                ])->first();
                if (empty($option)) {
                    continue;
                }
                $option->update([
                    'content' => $val,
                    'answer' => ($request->question_type != Question::TYPE_FILL_GAP)
                        ? (isset($request->answer[$k]) && !empty($request->answer[$k]) ? 1 : 0) : 1,
                ]);
            } else {

                if (in_array($request->question_type, [Question::TYPE_SINGLE, Question::TYPE_MULTIPLE, Question::TYPE_FILL_GAP])) {
                    QuestionOption::create([
                        'content' => $val,
                        'answer' => ($request->question_type != Question::TYPE_FILL_GAP)
                            ? (isset($request->answer[$k]) && !empty($request->answer[$k]) ? 1 : 0) : 1,
                        'question_id' => $questionId,
                    ]);
                }
            }
        }

        return;
    }

    /**
     * Get answer options of a question
     *
     * @param integer $questionId
     * @return object
     */
    public static function getAnswerOptions(int $questionId)
    {
        return self::select('question_type', DB::raw('GROUP_CONCAT(question_options.id) as answer_option'), DB::raw('GROUP_CONCAT(question_options.content) as answer_value'))
            ->leftJoin('questions', 'questions.id', '=', 'question_options.question_id')
            ->where([
                'question_options.question_id' => $questionId,
                'question_options.answer' => 1,
            ])->groupBy('question_options.question_id')->orderBy('question_options.id', 'ASC')->first();
    }
}
