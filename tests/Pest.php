<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Rubik\LaravelComments\Tests\TestSupport\Models\TestModel;
use Rubik\LaravelComments\Tests\TestSupport\Models\TestModelWithComments;
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

/**
 *
 * Helper function to create a test model
 *
 * @param string $model
 * @return TestModel|null
 */
function createTestModel(string $model = TestModel::class): ?TestModel
{
    $id = TestModel::factory()->create()->id;

    return $model::find($id);
}


