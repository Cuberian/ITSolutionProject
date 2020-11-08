<?php

namespace Database\Factories;

use App\Models\FriendConnection;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\UserVK;

class FriendConnectionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = FriendConnection::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => UserVK::factory()->create()->id,
            'friend_id' => UserVK::factory()->create()->id,
            'is_friend' => $this -> faker -> boolean
        ];
    }
}
