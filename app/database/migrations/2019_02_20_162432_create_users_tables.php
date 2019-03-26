<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('password')->nullable();
            $table->string('description')->nullable();
            $table->text('image')->nullable();
            $table->string('idea_title')->nullable();
            $table->string('idea_description')->nullable();
            $table->string('idea_needs')->nullable();
            $table->string('idea_value')->nullable();
            $table->string('idea_clients')->nullable();
            $table->integer('game_status')->default(0);
            $table->string('comment_validation')->nullable();
            $table->string('type')->nullable();
            $table->integer('sector_id')->unsigned()->nullable();
            $table->foreign('sector_id')->references('id')->on('sectors')->onDelete('cascade');
            $table->integer('role')->unsigned(); // 0 admin, 1 dynamizer, 2 user
            $table->integer('user_responsable_id')->unsigned()->nullable();
            $table->foreign('user_responsable_id')->references('id')->on('users');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('logs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->enum('item', ['competence', 'resource', 'allie']);
            $table->integer('item_id');
            $table->integer('game_id')->unsigned();
            $table->foreign('game_id')->references('id')->on('games');
            $table->boolean('won');
            $table->timestamps();
        });
        
        Schema::create('user_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->enum('item', ['competence', 'resource', 'allie']);
            $table->integer('item_id');
            $table->string('item_comment');
            $table->integer('level')->default(0);
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
        Schema::dropIfExists('user_items');
        Schema::dropIfExists('logs');
        Schema::dropIfExists('users');
    }
}
