<?php

use App\Models\Access;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class CreateAccessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_accesses', function (Blueprint $table) {
            $table->id('access_id');
            $table->string('name');
            $table->timestamps();       
            $table->softDeletes();     
        });

        $accesses = [
            'Budget Module', 'Expenses Module', 'Income Module'
        ];

        foreach ($accesses as $access) {
            Access::create(['name' => $access]);
        }
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_accesses');
    }
}
