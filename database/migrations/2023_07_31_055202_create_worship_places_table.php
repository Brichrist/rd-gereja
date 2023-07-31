<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('worship_places', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timeTz('time_start', $precision = 0);
            $table->timeTz('time_end', $precision = 0)->nullable();
            $table->enum("status",['1','0'])->comment('active:1,inactive:0')->default('1');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('worship_places');
    }
};
