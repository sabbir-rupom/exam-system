<?php

namespace App\Models\Quiz;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizQuestion extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'question_id',
        'quiz_id',
    ];

    public static function getQuestions(int $quizId)
    {
        $resultObj = QuizQuestion::select('question_id', 'questions.name')
            ->where('quiz_questions.quiz_id', $quizId)
            ->leftJoin('questions', 'questions.id', '=', 'quiz_questions.question_id')
            ->get();

        $result = [];
        if (!empty($resultObj)) {
            foreach ($resultObj as $value) {
                $result[$value->question_id] = $value->name;
            }
        }

        return $result;
    }

    /**
     * Create question set of the quiz
     *
     * @param Quiz $quiz
     * @return array Quiz question array
     */
    public static function makeQuestionSet(Quiz $quiz): array
    {
        $questionArray = QuizQuestion::select('questions.id', 'questions.difficulty', 'questions.question_type')
            ->where('quiz_questions.quiz_id', $quiz->id)
            ->where('questions.status', 1)
            ->leftJoin('questions', 'questions.id', '=', 'quiz_questions.question_id')
            ->get()->toArray();

        shuffle($questionArray);
        $qAmount = intval($quiz->question_amount);

        $difficultyOrder = $questions = [];
        // if($quiz->difficulty_order) {
        //     $difficultyOrder = json_decode($quiz->difficulty_order, true);

        //     if(!isset($difficultyOrder[1])) {
        //         $difficultyOrder = [];
        //     }
        // }

        while ($qAmount > 0) {
            $q = array_shift($questionArray);
            $questions[] = $q['id'];
            $qAmount--;
        }

        return $questions;
    }
}
