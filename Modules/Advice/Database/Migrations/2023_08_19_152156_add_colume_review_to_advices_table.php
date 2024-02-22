<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumeReviewToAdvicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('advices', function (Blueprint $table) {
            $table->string('rate_speed')->nullable()->default(0);
            $table->string('rate_quality')->nullable()->default(0);
            $table->string('rate_flexibility')->nullable()->default(0);
            $table->string('rate_adviser')->nullable();
            $table->string('rate_app')->nullable();
            $table->string('rate_other')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('advices', function (Blueprint $table) {
            $table->dropColumn('speed');
            $table->dropColumn('quality');
            $table->dropColumn('flexibility');
            $table->dropColumn('adviser');
            $table->dropColumn('app');
            $table->dropColumn('other');
        });
    }
}
