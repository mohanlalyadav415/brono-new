<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResourcesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tbl_resource', function (Blueprint $table) {
            $table->id('resource_id');
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('supplier_id');
            $table->string('name');
            $table->integer('creator_user_id'); 
            $table->integer('status');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('company_id')->references('company_id')->on('tbl_companies')->onDelete('cascade');
            $table->foreign('supplier_id')->references('supplier_id')->on('tbl_supplier')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_resource');
    }
};
