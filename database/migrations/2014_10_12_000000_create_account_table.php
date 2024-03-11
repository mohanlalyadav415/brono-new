<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class CreateAccountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_account', function (Blueprint $table) {
            $table->id('account_id');
            $table->integer('company_id'); 
            $table->integer('account_external_id'); 
            $table->string('account_name');
            $table->integer('creator_user_id'); 
            $table->integer('status');
            $table->timestamps();
            $table->softDeletes();             
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_account');
    }
}
