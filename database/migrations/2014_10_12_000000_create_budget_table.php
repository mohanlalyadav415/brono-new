<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class CreateBudgetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_budget', function (Blueprint $table) {
            $table->id('budget_id');
            $table->integer('company_id');  
            $table->integer('project_id');  
            $table->integer('budget_type_id');  
            $table->integer('expense_type_id');  
            $table->integer('movement_type_id');  
            $table->string('year');
            $table->integer('month_id');  
            $table->integer('amount');  
            $table->integer('qty');  
            $table->integer('creator_user_id'); 
            $table->integer('status');
            $table->timestamps();
            $table->softDeletes();    


            $table->index('company_id', 'company_id'); 
            $table->index('project_id', 'project_id');
            $table->index('budget_type_id', 'budget_type_id'); 
            $table->index('expense_type_id', 'expense_type_id'); 
            $table->index('movement_type_id', 'movement_type_id'); 
            $table->index('year', 'year'); 
            $table->index('month_id', 'month_id'); 

                     
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_budget');
    }
}
