<?php

namespace Database\Factories;

use App\Models\Group;
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
        $author_type = $this->faker->randomElement([UserVK::class, Group::class]);
        if($author_type  ===  UserVK::class) {
            $author = UserVK::factory()->create();

        }
        else {
            $author = Group::factory()->create();
        }
        return [
            'author_type' => $author_type,
            'author_id'=>$author->id,
            'wall_id'=>$author->wall_id,
            'text' => $this->faker->text(200),
            'picture' => $this->faker->imageUrl(400, 400),
            'toxicity' => $this->faker->randomFloat($nbMaxDecimals = 4, $min = 0, $max = 1),
        ];
    }
}
