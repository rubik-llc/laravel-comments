<?php
// config for Rubik/LaravelComments

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
    | The 'needs_approval' column indicates whether a comment needs to be approved
    | or not.
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
    */

    'cascade_on_delete' => true,

    /*
    |--------------------------------------------------------------------------
    | Default commenter name attribute
    |--------------------------------------------------------------------------
    |
    | The default attribute that returns the name of the commenter.
    |
    */

    'default_commenter_name_attribute' => 'name',

    /*
    |--------------------------------------------------------------------------
    | Commenter name attribute
    |--------------------------------------------------------------------------
    |
    | You can specify name attributes for each model that uses the CanComment Trait.
    | If a model doesn't exist in the array the 'default_commenter_name_attribute' will be returned.
    |
    */

    'commenter_name_attribute' => [
//        User::class => 'username'
    ]
];
