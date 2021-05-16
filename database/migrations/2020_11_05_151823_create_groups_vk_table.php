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
            $table->id('id');
            $table->bigInteger('wall_id')->unsigned();
            $table->unique('wall_id');
            $table->string('name');
            $table->string('screen_name');
            $table->longText('info');
            $table->string('avatar');
            $table->boolean('is_closed');
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
        Schema::dropIfExists('groups_vk');
    }
}
