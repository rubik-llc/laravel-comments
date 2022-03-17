<?php

namespace Rubik\LaravelComments\Traits;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Rubik\LaravelComments\Models\Comment;

trait HasComments
{
    /**
     * Indicates if comments should be deleted once the commentable is deleted.
     *
     * @var bool
     *
     * Add the following lines in the model that uses the trait to toggle cascade on delete.
     *
     * public static bool $cascadeCommentsOnDelete = true;
     */

    /**
     * Defines polymorphic relation between the model that uses this trait and Comment
     * @return MorphMany
     */
    public function comments(): MorphMany
    {
        return $this->morphMany(config('comments.comment_model'), 'commentable');
    }

    /**
     * Defines polymorphic relation between the model that uses this trait and Comment
     * @return MorphMany
     */
    public function approvedComments(): MorphMany
    {
        return $this->morphMany(config('comments.comment_model'), 'commentable')->approved();
    }

    /**
     * Attach a comment to this model
     *
     * @param string $comment
     * @param bool $needsApproval
     * @return bool|Model
     * @throws AuthenticationException
     */
    public function comment(string $comment, bool $needsApproval = null): Model|bool
    {
        if (! auth()->check()) {
            throw new AuthenticationException();
        }

        return $this->commentAs(auth()->user(), $comment, $needsApproval);
    }

    /**
     * Attach a comment to this model as a specific user
     *
     * @param $commenter
     * @param string $comment
     * @param bool $needsApproval
     * @return false|Comment
     */
    public function commentAs($commenter, string $comment, bool $needsApproval = null): bool|Comment
    {
        $commentClass = config('comments.comment_model');
        $comment = new $commentClass([
            'comment' => $comment,
            'commenter_id' => $commenter->getKey(),
            'commenter_type' => get_class($commenter),
            'commentable_id' => $this->getKey(),
            'commentable_type' => get_class(),
            'needs_approval' => $needsApproval ?? config('comments.needs_approval'),
        ]);

        return $this->comments()->save($comment);
    }

    /**
     * Returns all comments for this model with recursion and commenter eager loading.
     *
     * @return MorphMany
     */
    public function commentsWithCommentsAndCommenter(): MorphMany
    {
        return $this->morphMany(config('comments.comment_model'), 'commentable')->with(['commentsWithCommentsAndCommenter', 'commenter']);
    }

    /**
     * Delete all comments once the commentable model is deleted.
     */
    protected static function bootHasComments()
    {
        if (static::shouldCascadeOnDelete()) {
            static::deleted(function ($commentable) {
                foreach ($commentable->comments as $comment) {
                    $comment->delete();
                }
            });
        }
    }

    /**
     * Return if comments should be deleted when the commentable model is deleted.
     *
     * @return bool
     */
    protected static function shouldCascadeOnDelete(): bool
    {
        return static::$cascadeCommentsOnDelete ?? config('comments.cascade_on_delete');
    }
}
