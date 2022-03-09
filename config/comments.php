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
    | "$cascadeCommentsOnDelete" to the commentable class.
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
    | "$nameAttribute" to the commenter class.
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
    | By default
    */

    'silence_name_attribute_exception' => false,

    /*
    |--------------------------------------------------------------------------
    | Auth guard
    |--------------------------------------------------------------------------
    |
    | If your application uses a different auth guard from Laravel's default,
    | you can specify it here in order to retrieve the authenticated user.
    |
    | If you leave it "null", it will use Laravel's default guard.
    |
    */

    'auth_guard' => null,

];
