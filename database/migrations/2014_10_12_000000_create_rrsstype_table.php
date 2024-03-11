<?php

use App\Models\Rrsstype;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class CreateRrssTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_rrss_type', function (Blueprint $table) {
            $table->id('rrss_type_id');
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();            
        });

        $types = [
            'Instagram', 'Facebook', 'LinkedIn', 'TikTok'
        ];

        foreach ($types as $type) {
            Rrsstype::create(['name' => $type]);
        }

    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_rrss_type');
    }
}
