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
            $table->longText('value')->nullable();
            $table->enum("done",['-1','1'])->comment('before:-1,after:1')->default('1');
            $table->enum("type",['1','0'])->comment('spc:1,normal:0')->default('0');
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
