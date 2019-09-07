<?php


namespace Yevhenii\LaravelMigrationViseVersa\Helpers;


class StubReplacer {

    /**
     * @param        $stub
     * @param string $string
     * @return mixed
     */
    public static function replaceMigrationColumns($stub, string $string)
    {
        return str_replace('$columns', $string, $stub);
    }

    /**
     * @param       $stub
     * @param array $columns
     * @return mixed
     */
    public static function replaceModelColumns($stub, array $columns)
    {
        $string = '[\'' . implode('\',\'', $columns) . '\']';

        return str_replace('$columns', $string, $stub);
    }
}
