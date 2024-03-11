<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class CreateCompanyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_companies', function (Blueprint $table) {
            $table->id('company_id');
            $table->string('name'); 
            $table->string('rut');
            $table->string('business_activity');  
            $table->string('logo');  
            $table->string('webpage_url');  
            $table->string('rrss_url');  
            $table->integer('rrss_type_id');
            $table->string('address_line_1');
            $table->string('address_line_2');
            $table->integer('region_id');
            $table->integer('comuna_id');
            $table->integer('creator_user_id');
            $table->integer('status')->default(0);

            $table->timestamps();
            $table->softDeletes();

            $table->index('name', 'name');
            $table->index('rut', 'rut'); 

            
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_companies');
    }
}
