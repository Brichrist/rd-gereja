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
        Schema::create('detail_worship_templates', function (Blueprint $table) {
            $table->id();

            $table->integer('order');
            $table->bigInteger('id_worship_template');
            $table->bigInteger('id_activity_template');
            $table->integer('default_time')->nullable();

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
        Schema::dropIfExists('detail_worship_templates');
    }
};
