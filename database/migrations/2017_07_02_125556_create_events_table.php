<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            
            $table->string('name', 50);
            $table->string('short_address', 80);
            $table->text('address');
            $table->text('info');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->double('latitude', 15, 8);
            $table->double('longitude', 15, 8);
            $table->text('blueprint_img');
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
        Schema::dropIfExists('events');
    }
}
