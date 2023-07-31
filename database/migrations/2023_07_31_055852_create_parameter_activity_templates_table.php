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
        Schema::create('parameter_activity_templates', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_activity_template');
                
            $table->string('parameter_key');
            $table->enum("parameter_type",['2','1'])->comment('textarea:2,input:1')->default('1');
            $table->boolean('parameter_required')->default(false);
            $table->longText('parameter_value')->nullable();
            
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
        Schema::dropIfExists('parameter_activity_templates');
    }
};
