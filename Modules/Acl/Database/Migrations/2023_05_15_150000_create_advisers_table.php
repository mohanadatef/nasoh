<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdvisersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advisers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email')->unique()->index();
            $table->string('password');
            $table->string('mobile')->unique()->index();
            $table->string('full_name');
            $table->string('user_name')->unique()->index();
            $table->string('description')->nullable();
            $table->string('experience_year');
            $table->string('bank_name')->nullable();
            $table->string('bank_account')->nullable();
            $table->string('birthday')->nullable();
            $table->string('gender')->nullable();
            $table->string('country_id')->nullable()->default(0);
            $table->string('city_id')->nullable()->default(0);
            $table->string('nationality_id')->nullable()->default(0);
            $table->string('info')->nullable();
            $table->integer('status')->default(1);
            $table->text('token')->nullable();
            $table->string('lang')->default('ar')->index();
            $table->rememberToken();
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
        Schema::dropIfExists('advisers');
    }
}
