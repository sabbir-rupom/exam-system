<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OwnerUser extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'owner_id',
        'status',
        'activated_at',
    ];

    const USER_STUDENT = 1;
    const USER_TEACHER = 2;

    public function getTypes()
    {
        return [
            self::USER_STUDENT => 'student',
            self::USER_TEACHER => 'teacher',
        ];
    }
}
