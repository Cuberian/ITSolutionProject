<?php

namespace Database\Factories;

use App\Models\Group;
use Illuminate\Database\Eloquent\Factories\Factory;

class GroupFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Group::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'wall_id' => $this->faker->unique()->randomNumber(),
            'name' => $this->faker->name(),
            'screen_name' => $this->faker->name(),
            'info' => $this->faker->text(),
            'avatar' => $this->faker->imageUrl(200,200),
            'is_closed' => $this->faker->boolean(),
            'toxicity' => $this->faker->randomFloat($nbMaxDecimals=4, $min=0, $max=1)
        ];
    }
}
