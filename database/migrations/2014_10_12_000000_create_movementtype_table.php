<?php
use App\Models\MovementType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class CreateMovementTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_movement_type', function (Blueprint $table) {
            $table->id('movement_type_id');
            $table->string('name');
            $table->timestamps();       
            $table->softDeletes();     
        });

        $movementType = [
            'Income', 'Expense'
        ];

        foreach ($movementType as $movem) {
            MovementType::create(['name' => $movem]);
        }

    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_movement_type');
    }
}
