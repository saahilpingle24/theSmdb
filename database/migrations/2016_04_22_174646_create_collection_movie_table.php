<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCollectionMovieTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('collection_movie', function (Blueprint $table) {
            $table->integer('collection_id')->unsigned();
            $table->integer('movie_id')->unsigned();
            $table->foreign('collection_id')->references('id')->on('collections')->onDelete('cascade');
            $table->foreign('movie_id')->references('id')->on('movies')->onDelete('cascade');
            $table->primary(['movie_id', 'collection_id']);
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
        Schema::drop('collection_movie');
    }
}
