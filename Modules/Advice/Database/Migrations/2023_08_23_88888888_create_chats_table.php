<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chats', function (Blueprint $table) {
            $table->increments('id');
            $table->string('message')->nullable();
            $table->string('media_type')->default(0);
            $table->integer('adviser_id')->nullable()->index();
            $table->integer('client_id')->nullable()->index();
            $table->integer('advice_id')->unsigned()->index();
            $table->foreign('advice_id')->references('id')->on('advices')->onDelete('cascade');
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
        Schema::dropIfExists('chats');
    }
}
