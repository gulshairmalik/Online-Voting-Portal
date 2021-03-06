<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTempUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('temp__users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('nc');
            $table->string('username');
            $table->string('password');
            $table->string('cnic');
            $table->string('mob_no');
            $table->string('sms_code');
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
        Schema::dropIfExists('temp__users');
    }
}
