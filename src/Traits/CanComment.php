<?php

namespace Rubik\LaravelComments\Traits;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Rubik\LaravelComments\Models\Comment;

trait CanComment
{
    /**
     * Name of the column that should be identified as the commenter's name.
     *
     * @var string
     *
     * Add the following lines in the model that uses the trait to specify the name attribute.
     *
     * public string $nameAttribute = 'name';
     */

    /**
     * Defines polymorphic relation between the model that uses this trait and Comment
     * @return MorphMany
     */
    public function comments(): MorphMany
    {
        return $this->morphMany(config('comments.comment_model'), 'commenter');
    }

    /**
     * Attach a comment to the specified model.
     *
     * @param $model
     * @param string $comment
     * @param bool $needsApproval
     * @return false|Comment
     */
    public function commentTo($model, string $comment, bool $needsApproval = false): bool|Comment
    {
        $commentClass = config('comments.comment_model');
        $comment = new $commentClass([
            'comment' => $comment,
            'commenter_id' => $this->getKey(),
            'commenter_type' => get_class(),
            'commentable_id' => $model->getKey(),
            'commentable_type' => get_class($model),
            'needs_approval' => $needsApproval,
        ]);

        return $this->comments()->save($comment);
    }


    /**
     *
     * Get the name of the commenter.
     */
    public function getName()
    {
        $nameAttribute = $this->nameAttribute ?? config('comments.commenter_name_attribute');

//        TODO: check if attribute exists

        return $this->$nameAttribute;
    }

}
