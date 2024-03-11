<?php
use App\Models\Payment_status;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentStatusesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tbl_payment_status', function (Blueprint $table) {
            $table->id('payment_status_id');
            $table->string('name');
            $table->timestamps();
        });
        $paymentStatus = [
            'In review', 'Problem', 'Approved for payment', 'Payed', 'Dismissed' 
        ]; 

        foreach ($paymentStatus as $key => $value) {
            Payment_status::create(['name' => $value]);
        } 
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_payment_status');
    }
};
