<?php
use App\Models\Expense_source;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpenseSourcesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tbl_expense_source', function (Blueprint $table) {
            $table->id('expense_source_id');
            $table->string('name');
            $table->integer('shows_normal_expense_card');
            $table->timestamps();       
        });

        $source = [
            'Softland', 'Fincloud', 'ATGO.cl', 'Execution expense ATGO' 
        ];
        $shows = [
            '1', '1', '1', '0' 
        ];

        foreach ($source as $key => $value) {
            Expense_source::create(['name' => $value,'shows_normal_expense_card'=>$shows[$key]]);
        } 

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_expense_source');
    }
};
