<?php

namespace Rubik\LaravelComments;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Rubik\LaravelComments\Commands\LaravelCommentsCommand;

class LaravelCommentsServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-comments')
            ->hasConfigFile()
            ->hasMigration('create_laravel-comments_table')
            ->hasCommand(LaravelCommentsCommand::class);
    }
}
