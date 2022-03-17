<?php


use Carbon\Carbon;
use Rubik\LaravelComments\Models\Comment;
use Rubik\LaravelComments\Tests\TestSupport\Models\TestModel;
use Rubik\LaravelComments\Tests\TestSupport\Models\User;
use function Spatie\PestPluginTestTime\testTime;

beforeEach(function () {
    $this->user = User::factory()->create();
});

it('can return approved comments', function () {
    Comment::factory()->for($this->user, 'commenter')->create();
    Comment::factory()->for($this->user, 'commenter')->approved()->create();
    Comment::factory()->for($this->user, 'commenter')->needsApproval()->approved()->create();
    Comment::factory()->for($this->user, 'commenter')->needsApproval()->create();

    expect(Comment::approved()->count())->toBe(3);
    expect(Comment::count())->toBe(4);
});

it('belongs to commenter', function (string $model) {
    $comment = Comment::factory()->for($model::factory(), 'commenter')->create();
    $this->assertInstanceOf($model, $comment->commenter);
})->with([
    [User::class],
    [TestModel::class],
]);

it('belongs to commentable', function (string $model) {
    $comment = Comment::factory()->for($model::factory(), 'commentable')->create();
    $this->assertInstanceOf($model, $comment->commentable);
})->with([
    [TestModel::class],
    [Comment::class],
]);

it('can determine if a comment is approved', function ($data, $value) {
    expect($data->is_approved)->toBe($value);
})->with(
    [
        'needs approval and isn\'t approved' => [fn () => Comment::factory()->for($this->user, 'commentable')->needsApproval()->create(), false],
        'needs approval and is approved' => [fn () => Comment::factory()->for($this->user, 'commentable')->needsApproval()->approved()->create(), true],
        'doesn\'t need approval and is approved' => [fn () => Comment::factory()->for($this->user, 'commentable')->approved()->create(), true],
        'doesn\'t need approval and isn\'t approved' => [fn () => Comment::factory()->for($this->user, 'commentable')->create(), true],
    ]
);

it('can be approved', function ($data, $value) {
    testTime()->freeze();

    $comment = Comment::factory()->for($this->user, 'commentable')->needsApproval()->create();

    $comment->approve($data);
    expect($comment->refresh()->approved_at)->toBe($value);
})->with([
    'date as string' => ['2022-01-01', Carbon::parse('2022-01-01')->format('Y-m-d H:i:s')],
    'date as Carbon' => [Carbon::parse('2022-01-02'), Carbon::parse('2022-01-02')->format('Y-m-d H:i:s')],
    'no date' => [null, fn () => Carbon::now()->format('Y-m-d H:i:s')],
]);

it('can overwrite the approved_at of an approved comment', function () {
    $comment = Comment::factory()->for($this->user, 'commentable')->needsApproval()->approved()->create();
    $approved_at = $comment->refresh()->approved_at;

    $comment->approve(Carbon::parse('2022-01-01'));
    expect($comment->refresh()->approved_at)->toBe($approved_at);

    $comment->approve(Carbon::parse('2022-01-01'), true);
    expect($comment->refresh()->approved_at)->toBe(Carbon::parse('2022-01-01')->format('Y-m-d H:i:s'));
});

it('can be disapproved', function () {
    $comment = Comment::factory()->for($this->user, 'commentable')->needsApproval()->approved()->create();

    expect($comment->refresh()->approved_at)->not()->toBeNull();

    $comment->disapprove();
    expect($comment->refresh()->approved_at)->toBeNull();
});
