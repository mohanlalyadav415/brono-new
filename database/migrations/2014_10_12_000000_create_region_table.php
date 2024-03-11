<?php

use App\Models\Region;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class CreateRegionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_region', function (Blueprint $table) {
            $table->id('region_id');
            $table->string('name');
            $table->timestamps();     
            $table->softDeletes();       
        });

        $Regions = [
            'Region 1', 'Region 2'
        ];

        foreach ($Regions as $Region) {
            Region::create(['name' => $Region]);
        }
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_region');
    }
}
