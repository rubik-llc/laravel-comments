<?php

namespace Rubik\LaravelComments\Traits;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Rubik\LaravelComments\Models\Comment;

trait CanComment
{
    /**
     * Defines polymorphic relation between the model that uses this trait and Comment
     * @return MorphMany
     */
    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commenter');
    }

    public function getName()
    {
        $nameAttribute = config("comments.commenter_name_attribute.". get_class()) ?? config('comments.default_commenter_name_attribute');

        return $this->$nameAttribute;
    }
}
