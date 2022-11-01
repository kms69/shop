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
        Schema::create('process_definitons', function (Blueprint $table) {
            $table->id();
            $table->string('name','500');
            $table->string("description",'1000');
            $table->dateTime('created_date');
            $table->string("employee_username",'1000');
            $table->string("steps",'1000');
            $table->string("created_by",'1000');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('process_definitons');
    }
};
