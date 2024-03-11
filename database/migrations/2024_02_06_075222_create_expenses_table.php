<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpensesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tbl_expense', function (Blueprint $table) {
            $table->id('expense_id');
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('supplier_id');
            $table->unsignedBigInteger('source_id');
            $table->string('purchase_order_code');
            $table->string('document');
            $table->date('date');
            $table->unsignedBigInteger('dte_type_id');
            $table->integer('payment_status_id');
            $table->integer('creator_user_id'); 
            $table->integer('status');
            $table->timestamps();
            $table->softDeletes();


            $table->foreign('company_id')->references('company_id')->on('tbl_companies')->onDelete('cascade');
            $table->foreign('project_id')->references('project_id')->on('tbl_project')->onDelete('cascade');
            $table->foreign('supplier_id')->references('supplier_id')->on('tbl_supplier')->onDelete('cascade');
            $table->foreign('source_id')->references('expense_source_id')->on('tbl_expense_source')->onDelete('cascade');
            $table->foreign('dte_type_id')->references('dte_type_id')->on('tbl_dte_type')->onDelete('cascade');
        });


    } 

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_expense');
    }
};
