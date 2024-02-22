<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdviserSocialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adviser_socials', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('adviser_id')->unsigned()->index();
            $table->foreign('adviser_id')->references('id')->on('advisers')->onDelete('cascade');
            $table->integer('social_id')->unsigned()->index();
            $table->foreign('social_id')->references('id')->on('socials')->onDelete('cascade');
            $table->string('value');
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
        Schema::dropIfExists('adviser_socials');
    }
}
