<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersVkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_vk', function (Blueprint $table) {
            $table->id('vk_id');
            $table->bigInteger('vk_wall_id')->unsigned();
            $table->string('fullname');
            $table->string('avatar');
            $table->boolean('privacy');
            $table->integer('posts_count');
            $table->integer('friends_count');
            $table->integer('subscribers_count');
            $table->integer('groups_count');
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
        Schema::dropIfExists('users_vk');
    }
}
