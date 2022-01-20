<?php

namespace App\Models\Quiz;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Quiz extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'owner_id',
        'name',
        'question_amount',
        'duration',
        'pass_mark',
        'status',
        'type',
        'difficulty_order',
    ];

    const TYPE_UNCATEGORIZED = 0;
    const TYPE_RANDOM = 1;
    const TYPE_QUESTION_PAPER = 2;

    public static function addOrSave(Request $request, Quiz $quiz = null) {
        if(empty($quiz) || empty($quiz->id)) {
            $quiz = self::create([
                'owner_id' => session('owner')['id'],
                'name' => $request->name,
                'duration' => $request->duration,
                'question_amount' => $request->question_amount,
                'pass_mark' => $request->pass_mark,
                'type' => self::TYPE_RANDOM,
                'status' => isset($request->status) && intval($request->status) > 0 ? 1 : 0,
            ]);
        } else {
            $quiz->update([
                'name' => $request->name,
                'duration' => $request->duration,
                'question_amount' => $request->question_amount,
                'pass_mark' => $request->pass_mark,
                'status' => isset($request->status) && intval($request->status) > 0 ? 1 : 0,
            ]);

            QuizQuestion::where('quiz_id', $quiz->id)->delete();
        }

        $insertData = [];
        foreach ($request->questions as $qid) {
            $insertData[] = [
                'question_id' => $qid,
                'quiz_id' => $quiz->id,
                'created_at' => Carbon::now(),
            ];
        }
        QuizQuestion::insert($insertData);

        return $quiz;
    }
}
