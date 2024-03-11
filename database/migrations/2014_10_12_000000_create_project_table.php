<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class CreateProjectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_project', function (Blueprint $table) {
            $table->id('project_id');
            $table->integer('business_line_id');  
            $table->string('name');
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
        Schema::dropIfExists('tbl_project');
    }
}
