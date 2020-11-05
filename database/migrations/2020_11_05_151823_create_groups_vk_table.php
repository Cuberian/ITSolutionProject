<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupsVkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groups_vk', function (Blueprint $table) {
            $table->id('VK_id');
            $table->bigInteger('VK_wall_id')->unsigned();
            $table->unique('VK_wall_id');
            $table->string('group_info');
            $table->string('group_avatar');
            $table->boolean('group_privacy');
            $table->integer('group_subscribers_count');
            $table->integer('group_posts_count');
            $table->float('group_toxicity');
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
        Schema::dropIfExists('groups_vk');
    }
}
