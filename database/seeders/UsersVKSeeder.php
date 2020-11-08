<?php

namespace Database\Seeders;

use App\Models\UserVK;
use Illuminate\Database\Seeder;

class UsersVKSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserVK::factory()->times(5)->create();
    }
}
