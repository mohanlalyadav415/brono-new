<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tbl_service', function (Blueprint $table) {
            $table->id('service_id');
            $table->unsignedBigInteger('company_id');
            $table->string('name');
            $table->unsignedBigInteger('expense_type_id');
            $table->integer('cost_per_unit');
            $table->integer('creator_user_id'); 
            $table->integer('status');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('company_id')->references('company_id')->on('tbl_companies')->onDelete('cascade');
            $table->index('name', 'name'); 
            $table->foreign('expense_type_id')->references('expense_type_id')->on('tbl_expense_type')->onDelete('cascade');
        }); 
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_service');
    }
};
