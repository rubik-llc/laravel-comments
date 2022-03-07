<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Rubik\LaravelComments\Tests\TestCase;
use Rubik\LaravelComments\Tests\TestSupport\Models\User;
use function Pest\Laravel\actingAs;

uses(TestCase::class, RefreshDatabase::class)->in(__DIR__);

/**
 *
 * Helper function to log in
 *
 * @param User|null $user
 * @return void
 */
function login(User $user = null): void
{
    actingAs($user ?? User::factory()->create());
}

