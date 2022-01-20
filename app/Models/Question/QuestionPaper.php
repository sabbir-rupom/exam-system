<?php

namespace App\Models\Question;

use App\Models\Quiz\Quiz;
use App\Models\Quiz\QuizQuestion;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use stdClass;

class QuestionPaper extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category',
        'data',
        'slug',
    ];

    public static function init(Model $exam)
    {

        $qObj = new stdClass;
        $qObj->type = '';
        $qObj->qCnt = intval($exam->question_amount);
        $qObj->questions = [];

        $examQuestion = $usedQuestion = [];

        $qObj->data = [
            'header' => $exam->name,
            'footer' => '',
            'main' => [],
            'questions' => []
        ];

        if ($exam instanceof Quiz) {
            $qObj->questions = QuizQuestion::select('question_id', 'name', 'detail', 'question_type')
                ->leftjoin('questions', 'quiz_questions.question_id', '=', 'questions.id')
                ->where('quiz_id', $exam->id)
                ->orderBy('quiz_questions.created_at', 'ASC')
                ->get();

            $qObj->type = 'quiz';

        }

        if ($qObj->questions->count() > 0 && $qObj->qCnt > 0) {
            foreach ($qObj->questions as $k => $ques) {
                $examQuestion[] = [
                    'id' => intval($ques->question_id),
                    // 'question' => $ques->detail ? $ques->detail : $ques->name,
                    'question' => $ques->name,
                    'type' => intval($ques->question_type),
                    'mark' => 1,
                ];

                $usedQuestion[$ques->question_id] = $ques->name;

                $qObj->qCnt--;

                if ($qObj->qCnt <= 0) {
                    break;
                }
            }
        }

        $qPaper = QuestionPaper::where([
            'category' => $qObj->type,
            'exam_id' => $exam->id
        ])->first();

        if(!empty($qPaper) && $qPaper->id > 0) {
            $dataObj = json_decode($qPaper->data);

            dd($dataObj);
        } else {
            $qPaper = new QuestionPaper();
            $qPaper->category = $qObj->type;
            $qPaper->exam_id = $exam->id;
            $qPaper->slug = $qObj->type . '-' . time();
        }

        foreach ($examQuestion as $question) {
            $qObj->data['main'][] = [
                'group' => false,
                'question' => $question
            ];
        }

        $qObj->data['questions'] = $usedQuestion;

        $qPaper->data = json_encode($qObj->data, JSON_UNESCAPED_UNICODE);
        $qPaper->save();

        /**
         * Update exam data
         */
        $exam->type = QUIZ::TYPE_QUESTION_PAPER;
        $exam->save();

        return $qPaper;
    }

}
