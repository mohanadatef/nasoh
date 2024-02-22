<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->increments('id');
            $table->string('full_name');
            $table->string('email')->unique()->index();
            $table->string('mobile')->unique()->index();
            $table->integer('status')->default(1);
            $table->string('nationality_id')->nullable()->default(0);
            $table->string('country_id')->nullable()->default(0);
            $table->string('city_id')->nullable()->default(0);
            $table->string('gender')->nullable();
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
        Schema::dropIfExists('clients');
    }
}
