<?php

namespace App\Models\Question;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class Question extends Model
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
        'detail',
        'explanation',
        'difficulty',
        'status',
        'question_type',
    ];

    const DIFFICULTIES = [
        1 => 'Easy',
        2 => 'Medium',
        3 => 'Hard',
        4 => 'Extreme',
    ];

    const TYPE_SINGLE = 1;
    const TYPE_MULTIPLE = 2;
    const TYPE_FILL_GAP = 3;
    const TYPE_TEXT_SHORT = 4;
    const TYPE_TEXT_BROAD = 5;
    // const TYPE_MAPPING = 6;

    const EXAM_QUIZ = [
        Question::TYPE_SINGLE => [
            'slug' => 'single',
            'text' => 'Single Choice',
        ],
        Question::TYPE_MULTIPLE => [
            'slug' => 'multiple',
            'text' => 'Multiple Choice',
        ],
    ];

    const EXAM_WRITTEN = [
        Question::TYPE_FILL_GAP => [
            'slug' => 'fillgap',
            'text' => 'Fill in The Gaps',
        ],
        Question::TYPE_TEXT_SHORT => [
            'slug' => 'short',
            'text' => 'Short Text Answer',
        ],
        Question::TYPE_TEXT_BROAD => [
            'slug' => 'long',
            'text' => 'Broad Text Answer',
        ],
    ];

    /**
     * Get list of questions
     *
     * @return void
     */
    public static function questionList(array $filters = [], $pagination = true)
    {

        $selects = ['questions.id', 'questions.name', 'detail', 'difficulty', 'question_type', 'groups.name as group_name'];

        return Question::select($selects)
            ->leftJoin('question_groups', 'question_groups.question_id', '=', 'questions.id')
            ->leftJoin('groups', 'groups.id', '=', 'question_groups.group_id')
            ->where($filters)->paginate(10);
    }
}

