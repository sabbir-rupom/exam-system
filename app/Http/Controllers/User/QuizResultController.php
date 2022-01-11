<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\QuestionOption;
use App\Models\Quiz;
use App\Models\QuizAnswer;
use App\Models\QuizResult;
use DivisionByZeroError;
use ErrorException;
use Illuminate\Http\Request;

class QuizResultController extends Controller
{
    public function index(Request $request) {
        $filterArray = [
            'user_id' => auth()->user()->id,
            'result' => true
        ];

        if ($request->name_key && !empty($request->name_key)) {
            $filterArray['name_key'] = trim($request->name_key);
        }

        $quizzes = QuizResult::getQuizResults($filterArray);

        return view('user.quiz.result.index', [
            'quizResults' => $quizzes,
        ]);
    }

    public function showResult(QuizResult $quizResult)
    {
        if (empty($quizResult->id)) {
            return back()->with('status', 'Error! Result not found');
        }

        $quiz = Quiz::where([
            'user_id' => auth()->user()->id,
            'id' => $quizResult->quiz_id
        ])->first();

        if (empty($quiz)) {
            return back()->with('status', 'Error! Result not found');
        }

        try {
            $correctPercentage = ceil($quizResult->answers * 100 / intval($quizResult->questions));
        } catch (DivisionByZeroError $e) {
            return back()->with('status', $e->getMessage());
        } catch (ErrorException $e) {
            return back()->with('status', $e->getMessage());
        }

        $timeTakenSecs = $quizResult->duration % 60;
        $timeTakenMins = floor(($quizResult->duration - $timeTakenSecs) / 60);

        $quizInfo = [
            'exam_id' => $quizResult->id,
            'name' => $quizResult->quiz_name,
            'total_question' => $quizResult->questions,
            'total_correct' => $quizResult->answers,
            'pass_mark' => "$quizResult->pass_mark %",
            'correct_percentage' => "$correctPercentage %",
            // 'result' => $quizResult->result == Quiz::RESULT_PASS ? 'Pass' : ($quizResult->result == Quiz::RESULT_FAIL ? 'Fail' : 'Pending'),
            'result' => $quizResult->result,
            'time_taken' => (($timeTakenMins < 10) ? '0' . $timeTakenMins : $timeTakenMins) . ':'
            . (($timeTakenSecs < 10) ? '0' . $timeTakenSecs : $timeTakenSecs),
        ];

        $quizAnswers = QuizAnswer::where('quiz_result_id', $quizResult->id)->get();

        $correctAnswers = [];

        if ($quizAnswers->count() > 0) {
            foreach ($quizAnswers as $qa) {
                $qAnswer = QuestionOption::getAnswerOptions($qa->question_id);

                if (empty($qAnswer)) {
                    continue;
                }

                $tmpAns = explode(',', $qAnswer->answer_option);
                $tmpSub = json_decode($qa->value, true);
                if (Question::TYPE_SINGLE == $qAnswer->question_type && in_array($qa->option_id, $tmpAns)) {
                    $correctAnswers[] = $qa->question_id;
                } elseif (Question::TYPE_MULTIPLE == $qAnswer->question_type && same_array($tmpAns, $tmpSub)) {
                    $correctAnswers[] = $qa->question_id;
                }
            }

        }

        $questionData = Question::select('id', 'name', 'detail', 'difficulty')->whereIn('id', json_decode($quizResult->question_refs, true))->get();

        $questions = [];

        foreach ($questionData as $ques) {
            $questions[] = [
                'id' => $ques->id,
                'name' => $ques->name,
                'difficulty' => isset(Question::DIFFICULTIES[$ques->difficulty]) ? Question::DIFFICULTIES[$ques->difficulty] : 'Easy',
                'status' => in_array($ques->id, $correctAnswers),
            ];
        }

        return view('quiz-exam.result', [
            'quiz' => $quizInfo,
            'questions' => $questions,
        ]);
    }
}
