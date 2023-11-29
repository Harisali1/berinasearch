<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateListingsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('listings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->nullable();
            $table->integer('admin_id')->nullable();
            $table->integer('type_id')->unsigned();
            $table->string('title');
            $table->string('slug');
            $table->integer('no_of_room');
            $table->string('price');
            $table->string('image');
            $table->string('city');
            $table->decimal('lat')->nullable();
            $table->decimal('lng')->nullable();
            $table->text('location')->nullable();
            $table->text('address')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
            $table->foreign('type_id')->references('id')->on('types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('listings');
    }
}
