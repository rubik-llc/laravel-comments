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


it('has comments', function () {

    TestModel::factory()->create();

    $testModel = TestModelWithComments::first();

    Comment::factory()->for($testModel, 'commentable')->create();

    assertInstanceOf(Collection::class, $testModel->comments);
    expect($testModel->comments->count())->toBe(1);

});

it('can return all comments with commenter', function () {

    TestModelFactory::new()->create();

    $testModel = TestModelWithComments::first();
    //comments of $testmodel
    $comment1 = Comment::factory()->for($testModel, 'commentable')->create(['comment' => 'comment 1']);
    $comment2 = Comment::factory()->for($testModel, 'commentable')->create(['comment' => 'comment 2']);
    //comments of $comment1
    Comment::factory()->for($comment1, 'commentable')->create(['comment' => 'comment 1 - 1']);
    //comments of comment2
    Comment::factory()->for($comment2, 'commentable')->create(['comment' => 'comment 2 - 1']);
    Comment::factory()->for($comment2, 'commentable')->create(['comment' => 'comment 2 - 2']);
    Comment::factory()->for($comment2, 'commentable')->create(['comment' => 'comment 2 - 3']);

    $testModel->load('commentsWithCommentsAndCommenter');

    assertInstanceOf(Collection::class, $testModel->commentsWithCommentsAndCommenter);
    expect($testModel->commentsWithCommentsAndCommenter->count())->toBe(2);
    expect($testModel->commentsWithCommentsAndCommenter->first()->commentsWithCommentsAndCommenter->count())->toBe(1);
    assertInstanceOf(Model::class, $testModel->commentsWithCommentsAndCommenter->first()->commenter);
    expect($testModel->commentsWithCommentsAndCommenter->last()->commentsWithCommentsAndCommenter->count())->toBe(3);

});

it('can attach comments', function () {

    login();

    TestModelFactory::new()->create();

    $testModel = TestModelWithComments::first();

    $testModel->comment('test comment');

    assertDatabaseHas('comments', ['comment' => 'test comment', 'commenter_id' => auth()->id()]);
    expect($testModel->comments->count())->toBe(1);

});

it('can attach comments as a different user', function () {

    TestModelFactory::new()->create();

    $testModel = TestModelWithComments::first();

    $user = User::factory()->create();

    $testModel->commentAs($user, 'test comment');

    assertDatabaseHas('comments', ['comment' => 'test comment', 'commenter_id' => $user->id]);
    expect($testModel->comments->count())->toBe(1);

});


it('will delete all comments when a model is deleted', function () {

    TestModelFactory::new()->create();

    $testModel = TestModelWithComments::first();

    Comment::factory()->for($testModel, 'commentable')->create();
    Comment::factory()->for($testModel, 'commentable')->create();

    expect($testModel->comments->count())->toBe(2);

    $testModel->delete();

    expect($testModel->refresh()->comments->count())->toBe(0);

});


