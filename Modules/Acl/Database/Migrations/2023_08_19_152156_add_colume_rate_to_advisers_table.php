<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumeRateToAdvisersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('advisers', function (Blueprint $table) {
            $table->string('rate')->default(0);
            $table->string('speed')->default(0);
            $table->string('quality')->default(0);
            $table->string('flexibility')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('advisers', function (Blueprint $table) {
            $table->dropColumn('rate');
            $table->dropColumn('speed');
            $table->dropColumn('quality');
            $table->dropColumn('flexibility');
        });
    }
}
