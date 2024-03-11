<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class CreateExpenseTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_expense_type', function (Blueprint $table) {
            $table->id('expense_type_id');
            $table->integer('company_id');   
            $table->string('name');
            $table->unsignedBigInteger('account_debit_id');  
            $table->unsignedBigInteger('account_credit_id');  
            $table->unsignedBigInteger('cost_centre_id');  
            $table->integer('all_projects');  
            $table->integer('creator_user_id'); 
            $table->integer('status');
            $table->timestamps();
            $table->softDeletes();    


            $table->index('company_id', 'company_id'); 
            $table->index('name', 'name');   
            $table->foreign('account_debit_id')->references('account_id')->on('tbl_account')->onDelete('cascade');
 
            $table->foreign('account_credit_id')->references('account_id')->on('tbl_account')->onDelete('cascade');
 
            $table->foreign('cost_centre_id')->references('cost_centre_id')->on('tbl_cost_centre')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_expense_type');
    }
}
