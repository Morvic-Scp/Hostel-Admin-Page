<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingRecodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_recods', function (Blueprint $table) {
            $table->id();
            $table->integer("phone");
            $table->string("course_program");
            $table->date("start_date");
            $table->date("end_date");
            $table->integer("guardian_phone")->nullable();
            $table->string("address");
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('booking_recods');
    }
}
