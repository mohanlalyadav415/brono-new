<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_users', function (Blueprint $table) {
            $table->id('user_id');
            $table->string('dni');
            $table->string('name');
            $table->string('last_name_1');
            $table->string('last_name_2');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('superadmin')->nullable();
            $table->string('password');
            $table->foreignId('creator_user_id');
            $table->integer('status');
            $table->timestamps();
            $table->softDeletes();

            $table->index('dni', 'dni');
            $table->index('name', 'name');
            $table->index('last_name_1', 'last_name_1');
            $table->index('email', 'email');

            
        });
        User::create(['name' => 'admin','last_name_1' => 'admin','last_name_2' => 'admin','dni'=>'123456789-1','email' => 'admin@themesbrand.com','password' => Hash::make('12345678'),'created_at' => now(),'creator_user_id'=>'0','status'=>0]);
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_users');
    }
}
