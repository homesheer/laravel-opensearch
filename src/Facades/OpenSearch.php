<?php

namespace HomeSheer\OpenSearch\Facades;

use Illuminate\Support\Facades\Facade;

class OpenSearch extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'opensearch';
    }

}