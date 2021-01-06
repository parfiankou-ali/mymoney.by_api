<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
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
            $table->string('first_name', 64);
            $table->string('last_name', 64)->index();
            $table->string('middle_name', 64)->nullable();
            $table->tinyInteger('gender')->unsigned();
            $table->date('birth_date');
            $table->string('email', 255)->unique();
            $table->string('phone_number', 64)->nullable();
            $table->string('employee_code', 8)->unique();
            $table->string('password', 255);
            $table->integer('image_id')->unsigned()->nullable();
            $table->foreign('image_id')->references('id')->on('images')->onDelete('set null');
            $table->integer('company_id')->unsigned()->nullable();
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('set null');
            $table->tinyInteger('role')->unsigned()->nullable();
            $table->timestampsTz();
            $table->softDeletesTz();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
