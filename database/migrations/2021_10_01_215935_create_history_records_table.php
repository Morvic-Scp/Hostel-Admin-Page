<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoryRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('history_records', function (Blueprint $table) {
            $table->id()->unique();
            $table->integer("phone")->unique();
            $table->string("type");
            $table->integer("room_number");
            $table->string("executive")->default("Non-Executive");
            $table->integer("payment_status");
            $table->integer("payment_balance");
            $table->date("start_date");
            $table->string("course_program");
            $table->integer("guardian_phone");
            $table->string("address");
            $table->date("end_date");
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
        Schema::dropIfExists('history_records');
    }
}
