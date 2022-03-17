# Laravel comments

[![Latest Version on Packagist](https://img.shields.io/packagist/v/rubik-llc/laravel-comments.svg)](https://packagist.org/packages/rubik-llc/laravel-comments)
[![Check & fix styling](https://img.shields.io/github/workflow/status/rubik-llc/laravel-comments/Check%20&%20fix%20styling?label=check%20and%20fix%20styling)](https://github.com/rubik-llc/laravel-comments/actions/workflows/php-cs-fixer.yml)
![Platform](https://img.shields.io/badge/platform-laravel-red)
![GitHub all releases](https://img.shields.io/github/downloads/rubik-llc/laravel-comments/total)
[![GitHub Workflow Status](https://img.shields.io/github/workflow/status/rubik-llc/laravel-comments/run-tests?label=tests)](https://github.com/rubik-llc/laravel-comments/actions/workflows/run-tests.yml)
[![GitHub](https://img.shields.io/github/license/rubik-llc/laravel-comments)](LICENSE.md)

This package enables to easily associate comments to any Eloquent model in your Laravel application.

```php
//Associate a comment to a model as a logged in user
$post->comment('My comment!');

//Associate a comment to a model as a specific user
$post->commentAs($user, "Another user's comment!");
```

```php
//Associate a comment to a model directly from the user
$user->commentTo($post, 'Comment from user!');
```

## Installation

You can install the package via composer:

```bash
composer require rubik-llc/laravel-comments
```

Publish and run the migrations with:

```bash
php artisan vendor:publish --tag="comments-migrations"
php artisan migrate
```

Alternatively, you can publish the config file with:

```bash
php artisan vendor:publish --tag="comments-config"
```

This is the contents of the published config file:

```php
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
```

## Usage

### Registering the Commentable Model

In order to let your models have comments associated to them, simply add the `HasComments` trait to the class of that
model.

``` php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Rubik\LaravelComments\Traits\HasComments;

class Post extends Model
{
    use HasComments;
    
    ...
}
```

In addition to the configuration, you can specify whether the comments associated to a commentable class should be
deleted when the commentable model is deleted by adding the `$cascadeCommentsOnDelete` property to the class.

``` php
class Post extends Model
{
    use HasComments;
    
    public static bool $cascadeCommentsOnDelete = true;
    
    ...
}
```

### Registering the Commenter Model

In order to let a model be able to attach comments, add the `CanComment` trait to the class of that model.

``` php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Rubik\LaravelComments\Traits\CanComment;

class User extends Model
{
    use CanComment;
    
    ...
}
```

The `CanComment` trait appends a `commenter_name` attribute which returns the value of the attribute specified in the
config file. In addition to that you can specify the name attribute, the value of which the `commenter_name` will have
by adding the `$nameAttribute` property in the commenter class.

``` php
class User extends Model
{
    use CanComment;
    
    public string $nameAttribute = 'username';
    
    ...
}
```

In this case `$user->commenter_name` will return the same value as `$user->username`.

### Creating comments

1. To create a comment for the currently logged in user you can use the following syntax.

```php
$post->comment('First comment!');
```

Additionally, you can specify whether a comment needs to be approved by adding a bool value as a second parameter.

```php
$post->comment('Comment with default configuration!'); // this comment's approval is required based on configuration   

$post->comment('Comment with approval!', true); // this comment needs to be approved

$post->comment('Comment with no approval!', false); // this comment doesn't need to be approved
```

2. You can create comments as other users.

```php
$user = User::find(1);

$post->commentAs($user, 'First comment!');

$post->commentAs($user, 'Second comment!', true); // this comment needs to be approved
```

3. Eventually, comments can bre created directly from the user model.

```php
$post = Post::find(1);

$user->commentTo($post, 'First comment!');

$user->commentTo($post, 'Second comment!', true); // this comment needs to be approved
```

### Retrieving comments

1. Retrieving comments from the commentable model.

```php
$post = Post::find(1);

// Retrieve all comments
$post->comments;

// Retrieve only approved comments and those that don't need approval
$post->approvedComments;
```

2. Retrieving comments from the commenter model.

```php
$user = User::find(1);

// Retrieve all comments
$user->comments;

// Retrieve only approved comments and those that don't need approval
$user->approvedComments;
```

### Retrieving the commentable

```php
$comment = Comment::find(1);

// Retrieve the commentable model instance
$comment->commentable;
```

### Retrieving the commenter

```php
$comment = Comment::find(1);

// Retrieve the commenter model instance
$comment->commenter;
```

### Checking if comments are approved

To quickly check if a comment is approved use the `is_approved` attribute, it will return true if a comment is approved
or doesn't need approval, otherwise it will return false.

```php
$comment->is_approved // true/false
```

### Approving comments

```php
$comment = Comment::find(1);

$comment->approve(); 

$comment->approved_at // will return the date when the comment was approved
```

The `approve()` method accepts a string or a `Carbon` instance as a parameter to specify the `approved_at` date.

```php
$comment->approve('2022-01-01');

$comment->approved_at // will return '2022-01-01'
```

```php
$comment->approve(Carbon::parse('2022-02-02'));

$comment->approved_at // will return '2022-02-02'
```

By default, if you approve an already approved comment the `approved_at` value won't change.

```php
$comment->approved_at // '2020-01-18'

$comment->approve('2022-01-01');

$comment->approved_at // will return '2020-01-18'
```

You can overwrite the `approved_at` by adding a boolean value as a second parameter.

```php
$comment->approved_at // '2020-01-18'

$comment->approve('2022-01-01', true);

$comment->approved_at // will return '2022-01-01'
```

### Disapproving comments

```php
$comment = Comment::find(1); 

$comment->approved_at // '2022-01-01'

$comment->dissapprove();

$comment->approved_at // will return null
```

### Replying to comments

Since the `Comment` class uses the `HasComments` trait, it is possible to attach comments to other comments.

```php
$comment = Comment::find(1); 

$comment->comment('This is a reply for the first comment!')

$comment->comments // will return all replies for this comment
```

### Recursively retrieving comments

You can retrieve all comments with their children and commenter from the commentable using the `commentsWithCommentsAndCommenter()` relation.

```php
$post = Post::find(1); 

$post->commentsWithCommentsAndCommenter
```

### Cascade on delete

Deleting a commentable will also delete all comments that are attached to it.

### Using a custom Comment class

If you are using a custom comment class make sure it extends the default `Comment` class that is shipped with this
package.

``` php
namespace App\Models;
use Rubik\LaravelComments\Models\Comment;

class CustomComment extends Comment
{   
    ...
}
```

In addition to that, you need to set the `comment_model` value in the config file to the path of your custom class.

```php
// config/comments.php

return [
     ...
    
    'comment_model' => App\Models\CustomComment::class,  
     
     ...
]
````

```php
$post->comment('My custom comment!');

$post->comments->first(); // will return an instance of class CustomComment
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Rron Nela](https://github.com/rronik)
- [Yllndrit Beka](https://github.com/yllndritb)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
