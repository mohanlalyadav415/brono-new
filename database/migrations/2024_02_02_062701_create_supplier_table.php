<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupplierTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tbl_supplier', function (Blueprint $table) {
            $table->id('supplier_id');
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('organization_type_id');
            $table->string('name');
            $table->string('rut');
            $table->string('contacts_email');
            $table->string('contact_name');
            $table->unsignedBigInteger('dte_type_id');
            $table->integer('creator_user_id'); 
            $table->integer('status');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('company_id')->references('company_id')->on('tbl_companies')->onDelete('cascade');
            $table->foreign('organization_type_id')->references('organization_type_id')->on('tbl_organization_type')->onDelete('cascade');
            $table->index('name', 'name'); 
            $table->index('contact_name', 'contact_name'); 
            $table->foreign('dte_type_id')->references('dte_type_id')->on('tbl_dte_type')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_supplier');
    }
};
