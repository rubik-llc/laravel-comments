<?php

use Rubik\LaravelComments\Models\Comment;
use Rubik\LaravelComments\Tests\TestSupport\Models\TestModelComment;
use Rubik\LaravelComments\Tests\TestSupport\Models\TestModelWithComments;
use Rubik\LaravelComments\Tests\TestSupport\Models\User;
use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertInstanceOf;


/**
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */

beforeEach(function () {
    login();
});

it('can specify a different model as a comment class', function ($data) {

    $testModel = createTestModel(TestModelWithComments::class);

    config()->set('comments.comment_model', $data);

    $testModel->comment('test comment');

    assertInstanceOf($data, $testModel->comments->first());
})->with([
    'TestModelComment' => fn() => TestModelComment::class,
    'Comment' => fn() => Comment::class,
]);

it('can toggle whether to cascade comments when the commentable is deleted', function ($data, $count) {
    config()->set('comments.cascade_on_delete', $data);

    $testModel = createTestModel(TestModelWithComments::class);

    $testModel->comment('first comment');
    $testModel->comment('second comment');

    assertCount(2, Comment::all());

    $testModel->delete();

    assertCount($count, Comment::all());
})->with([
    'true' => [true, 0],
    'false' => [false, 2],
]);

it('will throw an exception if "silence_name_attribute_exception" is "false" and commenter does\'t have the default name attribute', function () {

    config()->set('comments.silence_name_attribute_exception', false);
    config()->set(['comments.commenter_name_attribute' => 'usernames']);

    $user = User::factory()->create();

    expect($user->commenter_name)->toBe($user->username);

})->throws(Exception::class, "Attribute 'usernames' does not exist in 'User'.");

it('will return the "commenter_name" as "null" if "silence_name_attribute_exception" is "true" and commenter does\'t have the default name attribute', function () {

    config()->set('comments.silence_name_attribute_exception', true);
    config()->set(['comments.commenter_name_attribute' => 'usernames']);

    $user = User::factory()->create();

    expect($user->commenter_name)->toBe(null);

});


