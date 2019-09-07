<?php


namespace Yevhenii\LaravelMigrationViseVersa\Helpers;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DbColumns {

    public static function getColumns($table)
    {
        return DB::select('show columns from ' . $table);
    }

    /**
     * @param $table
     * @return array
     */
    public static function getListColumns(string $table) : array
    {
        return Schema::getColumnListing($table);
    }
}
