<?php

use App\Models\Comuna;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class CreateComunaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_comuna', function (Blueprint $table) {
            $table->id('comuna_id');
            $table->integer('region_id');
            $table->string('name');
            $table->timestamps();      
            $table->softDeletes();      
        });

        $Comunas = [
            'Comuna 1', 'Comuna 2', 'Comuna 3', 'Comuna 4' 
        ];
        $region_id = [
            '1', '1', '2', '2' 
        ];

        foreach ($Comunas as $key => $Comuna) {
            Comuna::create(['name' => $Comuna,'region_id'=>$region_id[$key]]);
        } 
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_comuna');
    }
}
