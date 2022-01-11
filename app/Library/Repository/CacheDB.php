<?php

namespace App\Library\Repository;

use Illuminate\Support\Facades\Cache;

class CacheDB implements RepositoryInterface
{

    public static function all(string $class)
    {
        $model = self::getModel($class);

        return Cache::remember($model->getTable() . '.all', self::MINUTES, function () use ($model) {
            return $model->all();
        });
    }

    public static function find(string $class, int $id)
    {
        $model = self::getModel($class);

        return Cache::remember($model->getTable() . ".$id", self::MINUTES, function () use ($model, $id) {
            return $model->where('id', $id)->first();
        });
    }

    public static function findBy(string $class, array $filter)
    {
        $model = self::getModel($class);

        $cacheKey = '';
        foreach ($filter as $key => $value) {
            $cacheKey .= "_{$key}_{$value}_";
        }

        return Cache::remember($model->getTable() . ".$cacheKey", self::MINUTES, function () use ($model, $filter) {
            return $model->where($filter)->first();
        });
    }

    public static function findAll(string $class, array $filter)
    {
        $model = self::getModel($class);

        $cacheKey = '';
        foreach ($filter as $key => $value) {
            $cacheKey .= "_{$key}_{$value}_";
        }

        return Cache::remember($model->getTable() . ".$cacheKey", self::MINUTES, function () use ($model, $filter) {
            return $model->where($filter)->get();
        });
    }

    public static function update(string $class, array $data, array $filter)
    {
        $model = self::getModel($class);
        $model->where($filter)->update($data);

        $cacheKey = '';
        foreach ($filter as $key => $value) {
            $cacheKey .= "_{$key}_{$value}_";
        }

        $result = $model->where($filter)->first();
        Cache::put($model->getTable() . ".$cacheKey", $result, self::MINUTES);
        return $result;
    }

    public static function updateBy(string $class, array $data, int $id)
    {
        $model = self::getModel($class);
        $model->where('id', $id)->update($data);

        $result = $model->where('id', $id)->first();
        Cache::put($model->getTable() . ".$id", $result, self::MINUTES);
        return $result;
    }

    public static function delete(string $class, array $filter)
    {
        $model = self::getModel($class);
        $model->where($filter)->delete();

        $cacheKey = '';
        foreach ($filter as $key => $value) {
            $cacheKey .= "_{$key}_{$value}_";
        }

        Cache::delete($model->getTable() . ".$cacheKey");
        return;
    }

    public static function deleteBy(string $class, int $id)
    {
        $model = self::getModel($class);
        $model->where('id', $id)->delete();

        Cache::delete($model->getTable() . ".$id");
        return;
    }

    public static function getModel(string $modelClass)
    {
        return new $modelClass();
    }

}
