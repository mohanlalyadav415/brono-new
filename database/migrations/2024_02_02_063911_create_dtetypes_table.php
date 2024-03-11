<?php
use App\Models\Dtetype;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDtetypesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('﻿tbl_dte_type', function (Blueprint $table) {
            $table->id('dte_type_id');
            $table->string('name');
            $table->timestamps();
        }); 
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('﻿tbl_dte_type');
    }
};
