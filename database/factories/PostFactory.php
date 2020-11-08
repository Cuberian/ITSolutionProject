<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\UserVK;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user_vk = UserVK::factory()->create();
        return [
            'user_id'=>$user_vk->id,
            'wall_id'=>$user_vk->wall_id,
            'text' => $this->faker->text(200),
            'picture' => $this->faker->imageUrl(400, 400),
            'toxicity' => $this->faker->randomFloat($nbMaxDecimals = 4, $min = 0, $max = 1),
        ];
    }
}
