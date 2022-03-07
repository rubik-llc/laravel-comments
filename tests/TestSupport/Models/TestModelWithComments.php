<?php

namespace Rubik\LaravelComments\Tests\TestSupport\Models;

use Rubik\LaravelComments\Traits\HasComments;

class TestModelWithComments extends TestModel
{
    use HasComments;

    public static bool $cascadeCommentsOnDelete = true;

}
