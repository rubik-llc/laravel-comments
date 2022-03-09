<?php


use Illuminate\Support\Collection;
use Rubik\LaravelComments\Tests\TestSupport\Models\TestModelCommenter;
use Rubik\LaravelComments\Tests\TestSupport\Models\TestModelWithComments;
use Rubik\LaravelComments\Tests\TestSupport\Models\User;
use function Pest\Laravel\assertDatabaseHas;
use function PHPUnit\Framework\assertInstanceOf;
use Rubik\LaravelComments\Models\Comment;

it('will get the default name attribute from config file', function () {

    $user = User::factory()->create();
    expect($user->commenter_name)->toBe($user->name);

    config()->set(['comments.commenter_name_attribute' => 'username']);

    expect($user->commenter_name)->toBe($user->username);

});


it('can overwrite the default name attribute from config file', function () {

    $user = User::factory()->create();

    $testModelCommenter = createTestModel(TestModelCommenter::class);

    $user->nameAttribute = 'username';
    $testModelCommenter->nameAttribute = 'name';

    expect($user->commenter_name)->toBe($user->username);
    expect($testModelCommenter->commenter_name)->toBe($testModelCommenter->name);

});

it('has comments', function () {

    $user = User::factory()->create();

    Comment::factory()->for($user, 'commenter')->create();

    assertInstanceOf(Collection::class, $user->comments);
    expect($user->comments->count())->toBe(1);
});

it('can attach comments to a specified class', function () {

    $testModel = createTestModel(TestModelWithComments::class);

    $user = User::factory()->create();

    $user->commentTo($testModel, 'test comment');

    assertDatabaseHas('comments', ['comment' => 'test comment', 'commentable_type' => TestModelWithComments::class, 'commentable_id' => $testModel->id]);
    expect($testModel->comments->count())->toBe(1);
});
