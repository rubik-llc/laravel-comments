<?php

namespace Rubik\LaravelComments;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class CommentsServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-comments')
            ->hasConfigFile('comments')
            ->hasMigration('create_comments_table');
    }
}
