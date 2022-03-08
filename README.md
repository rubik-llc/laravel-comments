# Integrate comments easily into Models

[![Latest Version on Packagist](https://img.shields.io/packagist/v/rubik-llc/laravel-comments.svg?style=flat-square)](https://packagist.org/packages/rubik-llc/laravel-comments)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/rubik-llc/laravel-comments/Check%20&%20fix%20styling?label=code%20style)](https://github.com/rubik-llc/laravel-comments/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/rubik-llc/laravel-comments.svg?style=flat-square)](https://packagist.org/packages/rubik-llc/laravel-comments)
[![run-tests](https://github.com/rubik-llc/laravel-comments/actions/workflows/run-tests.yml/badge.svg)](https://github.com/rubik-llc/laravel-comments/actions/workflows/run-tests.yml)

This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

## Installation

You can install the package via composer:

```bash
composer require rubik-llc/laravel-comments
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="comments-config"
```

This is the contents of the published config file:

```php
return [
];
```
You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="comments-migrations"
php artisan migrate
```
## Usage

```php
$laravelComments = new Rubik\LaravelComments();
echo $laravelComments->echoPhrase('Hello, Rubik!');
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

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
