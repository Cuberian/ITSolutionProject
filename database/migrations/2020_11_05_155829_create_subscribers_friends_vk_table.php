<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscribersFriendsVkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscribers_friends_vk', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('vk_user_id')->unsigned();
            $table->foreign('vk_user_id')
                ->references('vk_id')
                ->on('users_vk')
                ->onDelete('cascade');
            $table->bigInteger('vk_friend_id')->unsigned();
            $table->foreign('vk_friend_id')
                ->references('vk_id')
                ->on('users_vk')
                ->onDelete('cascade');
            $table->boolean('is_friend');
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
        Schema::dropIfExists('subscribers_friends_vk');
    }
}
