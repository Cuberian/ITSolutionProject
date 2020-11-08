<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsVkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts_vk', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('wall_id')->unsigned();
            $table->foreign('wall_id')->references('wall_id')->on('groups_vk')->onDelete('cascade');
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('groups_vk')->onDelete('cascade');
            $table->string('text');
            $table->string('picture');
            $table->float('toxicity');
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
        Schema::dropIfExists('posts_vk');
    }
}
