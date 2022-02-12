<?php

namespace App\Module\TestPaper\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class Exam extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     * scratchcode.io
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'subject_id',
        'type',
        'name',
        'score',
        'pass_mark',
        'duration',
        'detail',
        'legacy',
        'format',
        'status'
    ];

    const TYPES = [
        0 => 'Uncategorized',
        1 => 'Quiz / MCQ',
        2 => 'Written'
    ];

    public static function getList(Request $request, $pagination = true) {

        $select = [
            'type', 'exams.name as exam_name', 'score', 'legacy',
            'subjects.name as subject_name', 'subjects.code as subject_code'
        ];

        if ($request->legacy) {
            $select[] = 'c_year';
        }

        $query = self::select()->leftJoin('subjects', 'subjects.id', '=', 'exams.subject_id');

        if($request->legacy) {
            $query = $query->leftJoin('legacy_exams', 'exam_id', '=', 'exams.id')
            ->where('legacy', 1);
        } else {
            $query = $query->where('legacy', 0);
        }

        if(!has_role(auth()->user(), 'admin')) {
            $query = $query->where('user_id', auth()->user()->id);
        }

        if($pagination) {
            return $query->latest()->paginate(10);
        }

        return $query->get();
    }

    /**
     * Get types of exam
     *
     * @param int|string $key
     * @return array|string|null
     */
    public static function getTypes($key = 'all') {
        if($key === 'all') {
            return self::TYPES;
        } elseif(isset(self::TYPES[$key])) {
            return self::TYPES[$key];
        } else {
            return null;
        }
    }
}
