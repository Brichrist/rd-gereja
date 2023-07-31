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
        Schema::create('activity_worships', function (Blueprint $table) {
            $table->id();
            $table->integer('order');
            $table->bigInteger('id_worship');
            $table->bigInteger('id_activity_template');
            $table->dateTime('time_start', $precision = 0);
            $table->dateTime('time_end', $precision = 0)->nullable();

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
        Schema::dropIfExists('activity_worships');
    }
};
