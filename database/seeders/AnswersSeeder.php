<?php

namespace Database\Seeders;

use App\Models\Answer;
use App\Models\Comment;
use Illuminate\Database\Seeder;

class AnswersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Answer::factory()->times(5)->create();
    }
}
