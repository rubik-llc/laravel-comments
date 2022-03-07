<?php

namespace Rubik\LaravelComments\Tests\TestSupport\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TestModel extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $table = 'test_models';

    protected $guarded = [];
}
