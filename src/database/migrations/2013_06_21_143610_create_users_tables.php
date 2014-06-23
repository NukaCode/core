<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTables extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->string('uniqueId', 10);
            $table->primary('uniqueId');
            $table->string('username')->unique();
            $table->string('password', 64);
            $table->string('firstName')->index();
            $table->string('lastName')->index();
            $table->string('displayName')->index();
            $table->string('location');
            $table->string('url');
            $table->integer('status_id')->unsigned()->index()->default(1);
            $table->string('email')->index();
            $table->timestamp('lastActive')->nullable();
            $table->string('gravatarEmail')->nullable();
            $table->string('remember_token', 100)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }

}
