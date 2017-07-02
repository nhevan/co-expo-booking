<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name', 80);
            $table->integer('stand_id')->unsigned();
            $table->foreign('stand_id')->references('id')->on('stands');
            $table->text('logo');
            $table->text('address');
            $table->string('phone', 15);
            $table->string('admin_name', 50);
            $table->string('admin_email', 50);

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
        Schema::dropIfExists('companies');
    }
}
