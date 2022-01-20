<?php

namespace App\Interfaces\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Interface ExamInterface
 * @package App\Interfaces\Models
 */
interface ExamInterface
{
    /**
     * @param array $attributes
     * @return Model
     */
    public static function add(array $data): Model;

    /**
     * @param $id
     * @return Model
     */
    public static function find($id): ?Model;

    /**
     * @param array $attributes
     * @return Model
     */
    public static function update(array $data): Model;

}
