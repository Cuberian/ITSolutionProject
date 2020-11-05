<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscribersGroupsVkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscribers_groups_vk', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('vk_group_id')->unsigned();
            $table->foreign('vk_group_id')
                ->references('vk_id')
                ->on('groups_vk')
                ->onDelete('cascade');
            $table->bigInteger('vk_user_id')->unsigned();
            $table->foreign('vk_user_id')
                ->references('vk_id')
                ->on('users_vk')
                ->onDelete('cascade');
            $table->boolean('is_admin');
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
        Schema::dropIfExists('subscribers_groups_vk');
    }
}
