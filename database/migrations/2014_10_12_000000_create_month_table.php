<?php
use App\Models\Month;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class CreateMonthTable extends Migration
{

    public function up()
    {
        Schema::create('tbl_month', function (Blueprint $table) {
            $table->id('month_id');
            $table->string('name');
            $table->timestamps();       
            $table->softDeletes();     
        });
        
        $months = [
            'January', 'February', 'March', 'April',
            'May', 'June', 'July', 'August',
            'September', 'October', 'November', 'December',
        ];

        foreach ($months as $month) {
            Month::create(['name' => $month]);
        }
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_month');
    }
}
