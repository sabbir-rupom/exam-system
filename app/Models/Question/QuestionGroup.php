<?php

namespace App\Models\Question;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class QuestionGroup extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'group_id',
        'question_id',
    ];

    public static function remove(Request $request)
    {
        $questionId = $request->question_id ? intval($request->question_id) : ($request->id ? intval($request->id) : 0);
        $groupId = $request->group ? intval($request->group) : ($request->group_id ? intval($request->group_id) : 0);

        QuestionGroup::where([
            'question_id' => $questionId,
            'group_id' => $groupId,
        ])->delete();

        return [
            'success' => true
        ];
    }
}
