<?php

namespace Rubik\LaravelComments\Tests\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Rubik\LaravelComments\Tests\TestSupport\Models\TestModel;

class TestModelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TestModel::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->text,
        ];
    }
}
