<?php

namespace App\Models\Question;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionType extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
    ];


    /**
     * Get question types array [ ID => Text ] or type string
     *
     * @param string $type
     * @return array|string
     */
    public static function getTypes(string $type = 'all')
    {

        $result = [];

        if($type === 'quiz') {
            foreach (Question::EXAM_QUIZ as $key => $value) {
                $result[$key] = $value['text'];
            }

        } elseif($type === 'written') {
            foreach (Question::EXAM_QUIZ as $key => $value) {
                $result[$key] = $value['text'];
            }
        } else {
            foreach ((Question::EXAM_QUIZ + Question::EXAM_WRITTEN) as $key => $value) {
                $result[$key] = $value['text'];
            }
        }

        return $result;
    }

}
