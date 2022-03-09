<?php

namespace Rubik\LaravelComments\Traits;

use Exception;
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
     * By design, the initializeCanComment method will be called dynamically on the Eloquent model instance.
     */
    public function initializeCanComment()
    {
        $this->append('commenter_name');
    }

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
     * The commenter_name attribute.
     */
    public function getCommenterNameAttribute()
    {
        return $this->getName();
    }

    /**
     *
     * Get the name of the commenter.
     * @throws Exception
     */
    public function getName()
    {
        $nameAttribute = $this->nameAttribute ?? config('comments.commenter_name_attribute');

        if (!isset($this->$nameAttribute) && !config('comments.silence_name_attribute_exception')){
            throw new Exception("Attribute '{$nameAttribute}' does not exist in '".class_basename($this)."'.");
        }

        return $this->$nameAttribute;
    }



}
