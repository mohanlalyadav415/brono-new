<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class CreateExpenseTypeProjectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_expense_type_project', function (Blueprint $table) {
            $table->id('expense_type_project_id');
            $table->unsignedBigInteger('expense_type_id');    
            $table->unsignedBigInteger('project_active_id');    
            $table->integer('creator_user_id'); 
            $table->integer('status');
            $table->timestamps();
            $table->softDeletes();    


            $table->index('expense_type_id', 'expense_type_id');  
            $table->index('project_active_id', 'project_active_id');  

            $table->foreign('expense_type_id')->references('expense_type_id')->on('tbl_expense_type')->onDelete('cascade');
            //$table->foreign('project_active_id')->references('project_id')->on('tbl_project')->onDelete('cascade');
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_expense_type_project');
    }
}
