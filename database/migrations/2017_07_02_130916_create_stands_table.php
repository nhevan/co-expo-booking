<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stands', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('stand_number');
            $table->integer('event_id')->unsigned();
            $table->foreign('event_id')->references('id')->on('events');
            $table->text('image');
            $table->text('description');
            $table->float('price', 8, 2);
            $table->float('length', 8, 2);
            $table->float('breadth', 8, 2);
            $table->float('x_cord', 8, 2);
            $table->float('y_cord', 8, 2);
            $table->boolean('is_booked')->default(false);
            
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
        Schema::dropIfExists('stands');
    }
}
