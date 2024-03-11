<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExecutionTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tbl_execution', function (Blueprint $table) {
            $table->id('execution_id');
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('project_id');
            $table->date('date');
            $table->integer('creator_user_id'); 
            $table->integer('status');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('company_id')->references('company_id')->on('tbl_companies')->onDelete('cascade');
            $table->foreign('project_id')->references('project_id')->on('tbl_project')->onDelete('cascade'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_execution');
    }
};
