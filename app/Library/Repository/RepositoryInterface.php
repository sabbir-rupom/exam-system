<?php

namespace App\Library\Repository;

interface RepositoryInterface
{
    const MINUTES = 60;

    public static function all(string $key);

    public static function find(string $key, int $id);

    public static function findBy(string $key, array $filter);

    public static function findAll(string $key, array $filter);

    public static function update(string $class, array $data, array $filter);

    public static function updateBy(string $class, array $data, int $id);

    public static function delete(string $key, array $filter);

    public static function deleteBy(string $key, int $id);
}
