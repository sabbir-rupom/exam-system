<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\QuizResult;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yadahan\AuthenticationLog\AuthenticationLog;

class DashboardController extends Controller
{
    public function index()
    {

        $totalQuiz = Quiz::where('user_id', auth()->user()->id)->count();
        $quizPerformances = QuizResult::select('result', DB::raw('COUNT(result) as cnt'))
        ->join('quizzes', 'quizzes.id', '=', 'quiz_results.quiz_id')
        ->where('result', '>', 0)
        ->where('quizzes.user_id', auth()->user()->id)
        ->groupBy('result')->get();

        $totalQuizPass = $totalQuizFail = 0;

        if ($quizPerformances->count() > 0) {
            foreach ($quizPerformances as $item) {
                if ($item->result == Quiz::RESULT_PASS) {
                    $totalQuizPass = $item->cnt;
                }
                if ($item->result == Quiz::RESULT_FAIL) {
                    $totalQuizFail = $item->cnt;
                }
            }
        }

        return view('user.index', [
            'total' => [
                'quizzes' => $totalQuiz,
                'quiz_pass' => $totalQuiz > 0 ? ceil($totalQuizPass * 100 / $totalQuiz) : 0,
                'quiz_fail' => $totalQuiz > 0 ? ceil($totalQuizFail * 100 / $totalQuiz) : 0,
            ],
        ]);
    }

}
