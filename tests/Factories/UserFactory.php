<?php

namespace Rubik\LaravelComments\Tests\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Rubik\LaravelComments\Tests\TestSupport\Models\User;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        $name = $this->faker->unique()->firstName();
        $lastName = $this->faker->unique()->lastName();
        $username = lcfirst($name[0]) . ucfirst($lastName);

        return [
            'name' => $name . " " . $lastName,
            'username' => $username,
            'email' => $username . "@hrm.net",
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return Factory
     */
    public function unverified(): Factory
    {
        return $this->state(
            [
                'email_verified_at' => null,
            ]
        );
    }
}
