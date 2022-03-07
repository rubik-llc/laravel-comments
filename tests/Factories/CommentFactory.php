<?php

namespace Rubik\LaravelComments\Tests\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Rubik\LaravelComments\Models\Comment;
use Rubik\LaravelComments\Tests\TestSupport\Models\TestModel;
use Rubik\LaravelComments\Tests\TestSupport\Models\TestModelWithComments;
use Rubik\LaravelComments\Tests\TestSupport\Models\User;

class CommentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Comment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'commenter_id' => User::factory(),
            'commenter_type' => User::class,
            'commentable_id' => TestModel::factory(),
            'commentable_type' => TestModelWithComments::class,
            'comment' => $this->faker->paragraph(),
        ];
    }

    /**
     * Requires a comment to be approved
     *
     * @param bool $value
     * @return Factory
     */
    public function needsApproval(bool $value = true): Factory
    {
        return $this->state([
            'needs_approval' => $value,
        ]);
    }

    /**
     * Sets the status of a comment to approved
     *
     * @param null $date
     * @return Factory
     */
    public function approved($date = null): Factory
    {
        return $this->state([
            'approved_at' => $date ? Carbon::parse($date) : Carbon::now(),
        ]);
    }
}
