<?php


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Rubik\LaravelComments\Models\Comment;
use Rubik\LaravelComments\Tests\Factories\TestModelFactory;
use Rubik\LaravelComments\Tests\TestSupport\Models\TestModel;
use Rubik\LaravelComments\Tests\TestSupport\Models\TestModelWithComments;
use Rubik\LaravelComments\Tests\TestSupport\Models\User;
use function Pest\Laravel\assertDatabaseHas;
use function PHPUnit\Framework\assertInstanceOf;


//it('will get the name attribute from config file', function () {
//
//    TestModel::factory()->create();
//
//    $testModel = TestModelWithComments::first();
//
//    $comment = Comment::factory()->for($testModel, 'commentable')->create();
//
////    dd($comment->commenter->getName());
////
////    assertInstanceOf(Collection::class, $testModel->comments);
////    expect($testModel->comments->count())->toBe(1);
//
//});



