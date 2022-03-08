<?php

namespace Rubik\LaravelComments\Tests\TestSupport\Models;

use Rubik\LaravelComments\Traits\CanComment;

class TestModelCommenter extends TestModel
{
    use CanComment;

//    public string $nameAttribute = 'name';
}
