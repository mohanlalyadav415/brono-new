<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpenseExecutionResourceTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tbl_expense_execution_resource', function (Blueprint $table) {
            $table->id('expense_execution_resource_id');
            $table->unsignedBigInteger('expense_id');
            $table->unsignedBigInteger('execution_resource_id');
            $table->date('sent_date');
            $table->integer('creator_user_id'); 
            $table->integer('status');
            $table->timestamps();
            $table->softDeletes();


            $table->foreign('expense_id')->references('expense_id')->on('tbl_expense')->onDelete('cascade');
            $table->foreign('execution_resource_id')->references('execution_resource_id')->on('tbl_execution_resource')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_expense_execution_resource');
    }
};
