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
            $table->id('id');
            $table->bigInteger('wall_id')->unsigned();
            $table->unique('wall_id');
            $table->string('fullname');
            $table->string('avatar');
            $table->boolean('privacy');
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
