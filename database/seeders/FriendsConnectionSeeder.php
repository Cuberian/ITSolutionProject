<?php

namespace Database\Seeders;

use App\Models\FriendConnection;
use Illuminate\Database\Seeder;

class FriendsConnectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FriendConnection::factory()->times(5)->create();
    }
}
