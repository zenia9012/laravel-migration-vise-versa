<?php

namespace yevhenii\LaravelMigrationViseVersa\Facades;

use Illuminate\Support\Facades\Facade;

class LaravelMigrationViseVersa extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravelmigrationviseversa';
    }
}
