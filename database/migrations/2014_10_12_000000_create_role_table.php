<?php

use App\Models\Role;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class CreateRoleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_roles', function (Blueprint $table) {
            $table->id('role_id');
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();            
        });

        $roles = [
            'Cheif', 'Standard'
        ];

        foreach ($roles as $role) {
            Role::create(['name' => $role]);
        }

    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_roles');
    }
}
