<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('answers', function (Blueprint $table) {
            $table->bigInteger('comment_id')->unsigned();
            $table->foreign('comment_id')
                ->references('id')
                ->on('comments_vk')
                ->onDelete('cascade');
            $table->bigInteger('answer_id')->unsigned();
            $table->foreign('answer_id')
                ->references('id')
                ->on('comments_vk')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('answers');
    }
}
