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
        Schema::create('activity_templates', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_worship_template');
            $table->integer('order');
            $table->string('activity');
            $table->longText('value')->nullable();
            $table->integer('default_time')->nullable();
            $table->enum("done",['-1','1'])->comment('before:-1,after:1')->default('1');
            $table->enum("type",['1','0'])->comment('spc:1,normal:0')->default('0');
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
        Schema::dropIfExists('activity_templates');
    }
};
