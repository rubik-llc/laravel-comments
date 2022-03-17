<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Comment class
    |--------------------------------------------------------------------------
    |
    | The comment class that should be used to store and retrieve the comments.
    | If you specify a different model class, make sure that model extends the default
    | Comment model that is shipped with this package.
    |
    */

    'comment_model' => \Rubik\LaravelComments\Models\Comment::class,

    /*
    |--------------------------------------------------------------------------
    | Needs approval
    |--------------------------------------------------------------------------
    |
    | By default, when creating comments they don't need approval (unless specified otherwise).
    | You can change the default value here.
    |
    */

    'needs_approval' => false,

    /*
    |--------------------------------------------------------------------------
    | Cascade on delete
    |--------------------------------------------------------------------------
    |
    | When this option is enabled, all related comments will be deleted when
    | the commentable class is deleted.
    |
    | If you want to overwrite this config for a specific class, you need to add
    | "$cascadeCommentsOnDelete" property to the commentable class.
    |
    | E.g:
    |
    |   class Commentable extends Model
    |   {
    |       use HasComments;
    |
    |       public static bool $cascadeCommentsOnDelete = false;
    |       ...
    |
    */

    'cascade_on_delete' => true,

    /*
    |--------------------------------------------------------------------------
    | Commenter name attribute
    |--------------------------------------------------------------------------
    |
    | The default attribute that returns the name of the commenter. Every class
    | that uses the "CanComment" trait will have the "commenter_name" attribute
    | appended, which will return the value of the attribute specified here.
    |
    | If you want to overwrite this config for a specific class, you need to add
    | "$nameAttribute" property to the commenter class.
    |
    | E.g:
    |
    |   class Commenter extends Model
    |   {
    |       use CanComment;
    |
    |       public string $nameAttribute = 'username';
    |       ...
    |
    */

    'commenter_name_attribute' => 'name',

    /*
    |--------------------------------------------------------------------------
    | Silence name attribute exception
    |--------------------------------------------------------------------------
    |
    | By default, if the class that uses the "CanComment" trait doesn't have the
    | name attribute specified in the "commenter_name_attribute" option or in
    | the "$nameAttribute" property, an exception will be thrown. If you enable
    | this option, no exception will be thrown and the "commenter_name" attribute
    | will return "null" if it can't find the specified name attribute.
    |
    */

    'silence_name_attribute_exception' => false,

];
