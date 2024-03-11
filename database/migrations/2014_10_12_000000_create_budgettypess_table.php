<?php
use App\Models\Budgettype;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class CreateBudgetTypessTable extends Migration
{

    public function up()
    {
        Schema::create('tbl_budget_type', function (Blueprint $table) {
            $table->id('budget_type_id');
            $table->string('name');
            $table->timestamps();       
            $table->softDeletes();     
        });
        
        $estimate = [
            'Estimate', 'Client', 'Internt' 
        ];
 
        foreach ($estimate as $value) {
            Budgettype::create(['name' => $value]);
        }
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_budget_type');
    }
}
