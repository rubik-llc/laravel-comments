# Laravel comments

[![Latest Version on Packagist](https://img.shields.io/packagist/v/rubik-llc/laravel-comments.svg?style=flat-square)](https://packagist.org/packages/rubik-llc/laravel-comments)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/rubik-llc/laravel-comments/Check%20&%20fix%20styling?label=code%20style)](https://github.com/rubik-llc/laravel-comments/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)

[//]: # ([![Total Downloads]&#40;https://img.shields.io/packagist/dt/rubik-llc/laravel-comments.svg?style=flat-square&#41;]&#40;https://packagist.org/packages/rubik-llc/laravel-comments&#41;)
[![run-tests](https://github.com/rubik-llc/laravel-comments/actions/workflows/run-tests.yml/badge.svg)](https://github.com/rubik-llc/laravel-comments/actions/workflows/run-tests.yml)

This package enables to easily associate comments to any Eloquent model in your Laravel application.

```php
//Associate a comment to a model as a logged in user
$myModel->comment('My comment!');

//Associate a comment to a model as a specific user
$myModel->commentAs($user, "Another user's comment!");
```

```php
//Associate a comment to a model directly from the user
$user->commentTo($myModel, 'Comment from user!');
```

## Requirements
- php
- laravel

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
];
```
## Usage

###Registering Models

In order to let your models have comments associated to them, simply add the `HasComments` trait to the class of that model.

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

To create a comment for the currently logged in user you can use the following syntax.

```php
$myModel->comment('First comment!');
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
