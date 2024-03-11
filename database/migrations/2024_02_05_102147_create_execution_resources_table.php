<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExecutionResourcesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tbl_execution_resource', function (Blueprint $table) {
            $table->id('execution_resource_id');
            $table->unsignedBigInteger('execution_id'); 
            $table->unsignedBigInteger('resource_id');
            $table->unsignedBigInteger('service_id');
            $table->integer('qty');
            $table->unsignedBigInteger('time_id');
            $table->integer('creator_user_id'); 
            $table->integer('status');
            $table->timestamps();
            $table->softDeletes();

            
            $table->foreign('execution_id')->references('execution_id')->on('tbl_execution')->onDelete('cascade');
            $table->foreign('resource_id')->references('resource_id')->on('tbl_resource')->onDelete('cascade');
            $table->foreign('service_id')->references('service_id')->on('tbl_service')->onDelete('cascade');
            $table->foreign('time_id')->references('time_id')->on('tbl_time')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_execution_resource');
    }
};
