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
     * @param integer $id
     * @return array|string
     */
    public static function getTypes(int $id = 0)
    {

        $result = [];

        foreach (Question::EXAM_QUIZ as $key => $value) {
            $result[$key] = $value['text'];
        }
        foreach (Question::EXAM_WRITTEN as $key => $value) {
            $result[$key] = $value['text'];
        }
        if ($id > 0 && isset($result[$id])) {
            return $result[$id];
        }

        return $result;
    }

}
