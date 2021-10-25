<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomPopulationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('room_population', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->integer("room_num")->unique();
            $table->integer("price");
            $table->integer("beds");
            $table->string("description");
            $table->binary("image");
            $table->string("room_type")->default("Non-executive")->nullable();
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
        Schema::dropIfExists('room_population');
    }
}
