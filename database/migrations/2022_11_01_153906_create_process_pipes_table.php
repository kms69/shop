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
        Schema::create('process_pipes', function (Blueprint $table) {
            $table->id();
            $table->integer("process_id");
            $table->integer("current_step");
            $table->dateTime('deadline');
            $table->string("data",'2000');
            $table->enum('finished', ['1', '0'])->default('0');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('process_pipes');
    }
};
