<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpenseNormalsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tbl_expense_normal', function (Blueprint $table) {
            $table->id('expense_normal_id');
            $table->unsignedBigInteger('expense_id');
            $table->unsignedBigInteger('expense_type_id');
            $table->integer('amount');
            $table->integer('qty');
            $table->integer('creator_user_id'); 
            $table->integer('status');
            $table->timestamps();
            $table->softDeletes();


            $table->foreign('expense_id')->references('expense_id')->on('tbl_expense')->onDelete('cascade');
            $table->foreign('expense_type_id')->references('expense_type_id')->on('tbl_expense_type')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_expense_normal');
    }
};
