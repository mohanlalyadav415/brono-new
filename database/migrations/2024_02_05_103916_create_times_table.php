<?php
use App\Models\Time;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tbl_time', function (Blueprint $table) {
            $table->id('time_id');
            $table->string('name');
            $table->timestamps();
        });


        $startTime = new DateTime('6:00');
        $endTime = new DateTime('23:45');
        $interval = new DateInterval('PT15M');

        $currentTime = clone $startTime;

        while ($currentTime <= $endTime) {
            Time::create(['name' => $currentTime->format('H:i')]);
            $currentTime->add($interval);
        }

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_time');
    }
};
