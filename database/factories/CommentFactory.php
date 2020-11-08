<?php

namespace Database\Factories;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\UserVK;
use App\Models\Group;
use App\Models\Post;
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
        $author_type = $this->faker->randomElement([UserVK::class, Group::class]);
        if($author_type  ===  UserVK::class) {
            $author_id = UserVK::factory()->create()->id;
        }
        else {
            $author_id = Group::factory()->create()->id;
        }
        return [
            'author_type' => $author_type,
            'author_id' => $author_id,
            'post_id'=>Post::factory()->create()->id,
            'text' => $this->faker->text(100),
            'picture' => $this->faker->imageUrl(200, 200),
            'toxicity' => $this->faker->randomFloat($nbMaxDecimals = 4, $min = 0, $max = 1)
        ];
    }
}
