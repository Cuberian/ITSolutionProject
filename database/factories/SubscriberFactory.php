<?php

namespace Database\Factories;

use App\Models\Group;
use App\Models\Subscriber;
use App\Models\UserVK;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubscriberFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Subscriber::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        dump(UserVK::factory()->create()->id);
        return [
            'user_id' => UserVK::factory()->create()->id,
            'group_id' => Group::factory()->create()->id,
            'is_admin' => $this->faker->boolean
        ];
    }
}
