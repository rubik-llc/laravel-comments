<?php

namespace Rubik\LaravelComments\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Rubik\LaravelComments\LaravelComments
 */
class LaravelComments extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laravel-comments';
    }
}
