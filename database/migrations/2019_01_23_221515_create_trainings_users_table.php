<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrainingsUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trainings_users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('training_id')->unsigned()->index();
            $table->integer('user_id')->unsigned()->index();
            $table->foreign('training_id')->references('id')->on('trainings')->onCascade('delete');
            $table->foreign('user_id')->references('id')->on('users')->onCascade('delete');
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
        Schema::dropIfExists('trainings_users');
    }
}
