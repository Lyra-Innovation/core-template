<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use App\ViewComponent;

class CreateStaticTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resources', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('image');
            $table->timestamps();
        });

        Schema::create('allies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('image');
            $table->timestamps();
        });

        Schema::create('competences', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('max_level')->notNull()->default(8);
            $table->string('image');
            $table->timestamps();
        });

        Schema::create('sectors', function (Blueprint $table) {
          $table->increments('id');
          $table->string('name');
          $table->string('image');
          $table->timestamps();
        });

        Schema::create('sector_competences', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('sector_id')->unsigned();
          $table->foreign('sector_id')->references('id')->on('sectors')->onDelete('cascade');
          $table->integer('competence_id')->unsigned();
          $table->foreign('competence_id')->references('id')->on('competences')->onDelete('cascade');
          $table->timestamps();
        });

        // Minigames
        Schema::create('games', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('questions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('question');
            $table->timestamps();
        });

        Schema::create('answers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('question_id')->unsigned();
            $table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade');
            $table->string('answer');
            $table->boolean('correct');
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
        Schema::dropIfExists('answers');
        Schema::dropIfExists('questions');
        Schema::dropIfExists('games');
        Schema::dropIfExists('sector_competences');
        Schema::dropIfExists('sectors');
        Schema::dropIfExists('competences');
        Schema::dropIfExists('allies');
        Schema::dropIfExists('resources');
    }
}
