<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTerminalLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('terminal_locations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('address');
            $table->decimal('longitude',9, 6);
            $table->decimal('latitude', 9, 6);
            $table->string('terminal');
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
        Schema::dropIfExists('terminal_locations');
    }
}