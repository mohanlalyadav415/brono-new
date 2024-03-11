<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class CreateUsersaccessTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_users_access', function (Blueprint $table) {
            $table->id('user_access_id');
            $table->integer('user_id');
            $table->integer('company_id');
            $table->integer('access_id')->nullable();;
            $table->string('role_id');
            $table->integer('creator_user_id'); 
            $table->integer('status');
            $table->timestamps();
            $table->softDeletes();

            $table->index('user_id', 'user_id'); 
            $table->index('company_id', 'company_id');
            $table->index('access_id', 'access_id'); 

            
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_users_access');
    }
}
