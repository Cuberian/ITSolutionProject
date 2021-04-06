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
            $table->string('author_type');
            $table->bigInteger('author_id');
            $table->bigInteger('wall_id');
            $table->string('text');
            $table->string('picture')->nullable();
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
