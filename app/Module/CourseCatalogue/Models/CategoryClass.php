<?php

namespace App\Module\CourseCatalogue\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryClass extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category_id',
        'name',
        'code',
    ];

    public static function classByCategory(bool $pagination = true, bool $select = false)
    {
        $columns = [
            'category_classes.id', 'category_classes.name as class_name', 'category_classes.code as class_code',
            'categories.name as category_name', 'categories.code as category_code', 'categories.id as category_id'
        ];

        $query = CategoryClass::select($columns)
            ->join('categories', 'categories.id', '=', 'category_classes.category_id');

        if($select) {
            $classData = $query->get();
            $resultArray = [];
            foreach ($classData as $class) {
                $resultArray[$class->category_id][] = [
                    'value' => "{$class->class_name} ({$class->class_code})",
                    'id' => $class->id
                ];
            }

            return $resultArray;

        } elseif($pagination) {
            return $query->paginate(10);
        } else {
            return $query->get();
        }
    }
}
