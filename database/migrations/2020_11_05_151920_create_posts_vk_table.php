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
            $table->id('vk_post_id');
            $table->bigInteger('vk_wall_id')->unsigned();
            $table->foreign('vk_wall_id')->references('VK_wall_id')->on('groups_vk')->onDelete('cascade');
            $table->bigInteger('vk_id')->unsigned();
            $table->foreign('vk_id')->references('VK_id')->on('groups_vk')->onDelete('cascade');
            $table->string('vk_post_text');
            $table->string('vk_post_pic');
            $table->float('post_toxicity');
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
