<?php

use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use function Pest\Laravel\assertDatabaseHas;
use function PHPUnit\Framework\assertInstanceOf;
use Rubik\LaravelComments\Models\Comment;
use Rubik\LaravelComments\Tests\TestSupport\Models\TestModelWithComments;
use Rubik\LaravelComments\Tests\TestSupport\Models\User;

beforeEach(function () {
    $this->testModel = createTestModel(TestModelWithComments::class);
});

it('has comments', function () {
    Comment::factory()->for($this->testModel, 'commentable')->create();

    assertInstanceOf(Collection::class, $this->testModel->comments);
    expect($this->testModel->comments->count())->toBe(1);
});

it('can return all comments with commenter', function () {

    //comments of $this->testModel
    $comment1 = Comment::factory()->for($this->testModel, 'commentable')->create(['comment' => 'comment 1']);
    $comment2 = Comment::factory()->for($this->testModel, 'commentable')->create(['comment' => 'comment 2']);
    //comments of $comment1
    Comment::factory()->for($comment1, 'commentable')->create(['comment' => 'comment 1 - 1']);
    //comments of comment2
    Comment::factory()->for($comment2, 'commentable')->create(['comment' => 'comment 2 - 1']);
    Comment::factory()->for($comment2, 'commentable')->create(['comment' => 'comment 2 - 2']);
    Comment::factory()->for($comment2, 'commentable')->create(['comment' => 'comment 2 - 3']);

    $this->testModel->load('commentsWithCommentsAndCommenter');

    assertInstanceOf(Collection::class, $this->testModel->commentsWithCommentsAndCommenter);
    expect($this->testModel->commentsWithCommentsAndCommenter->count())->toBe(2);
    expect($this->testModel->commentsWithCommentsAndCommenter->first()->commentsWithCommentsAndCommenter->count())->toBe(1);
    assertInstanceOf(Model::class, $this->testModel->commentsWithCommentsAndCommenter->first()->commenter);
    expect($this->testModel->commentsWithCommentsAndCommenter->last()->commentsWithCommentsAndCommenter->count())->toBe(3);
});

it('can attach comments', function () {
    login();

    $this->testModel->comment('test comment');

    assertDatabaseHas('comments', ['comment' => 'test comment', 'commenter_id' => auth()->id()]);
    expect($this->testModel->comments->count())->toBe(1);
});

it('will return authentication exception if you are not logged in and try to attach comments', function () {
    $this->testModel->comment('test comment');
})->throws(AuthenticationException::class);

it('can overwrite the default config for approval', function () {
    login();

    $this->testModel->comment('default test comment');

    $this->testModel->comment('needs approval test comment', true);
    $this->testModel->comment('doesn\'t need approval test comment', false);

    assertDatabaseHas('comments', ['comment' => 'default test comment', 'needs_approval' => config('comments.needs_approval')]);
    assertDatabaseHas('comments', ['comment' => 'needs approval test comment', 'needs_approval' => true]);
    assertDatabaseHas('comments', ['comment' => 'doesn\'t need approval test comment', 'needs_approval' => false]);
});

it('can attach comments as a different user', function () {
    $user = User::factory()->create();

    $this->testModel->commentAs($user, 'test comment');

    assertDatabaseHas('comments', ['comment' => 'test comment', 'commenter_id' => $user->id]);
    expect($this->testModel->comments->count())->toBe(1);
});


it('can retrieve only approved comments', function () {
    login();

    $this->testModel->comment('not approved test comment', true);
    $this->testModel->comment('approved comment')->approved();
    $this->testModel->comment('approved comment')->approved();

    expect($this->testModel->comments->count())->toBe(3);
    expect($this->testModel->approvedComments->count())->toBe(2);

});
