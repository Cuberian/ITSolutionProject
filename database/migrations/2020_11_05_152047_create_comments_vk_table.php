<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsVkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments_vk', function (Blueprint $table) {
            $table->id('vk_comment_id');
            $table->string('user_type');
            $table->bigInteger('vk_id');
            $table->string('vk_comm_text');
            $table->string('vk_comm_pic');
            $table->float('comm_toxicity');
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
        Schema::dropIfExists('comments_vk');
    }
}
