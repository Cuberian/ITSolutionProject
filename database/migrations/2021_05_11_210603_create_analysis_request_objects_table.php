<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnalysisRequestObjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('analysis_request_objects', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('request_id')->unsigned();
            $table->foreign('request_id')
                ->references('id')
                ->on('analysis_request')
                ->onDelete('cascade');
            $table->string('type');
            $table->bigInteger('object_id')->nullable();
            $table->string('requested_id');
            $table->enum('analysis_type',['error', 'success']);
            $table->string('result_description');
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
        Schema::dropIfExists('analysis_request_objects');
    }
}
