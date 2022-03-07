<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\actingAs;
use Rubik\LaravelComments\Tests\TestCase;
use Rubik\LaravelComments\Tests\TestSupport\Models\User;

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
