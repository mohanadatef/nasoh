<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeColumeRejectToCommentAdvicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('advices', function (Blueprint $table) {
            $table->dropColumn('reject');
            $table->dropColumn('reject_note');
            $table->string('comment_other')->nullable();
            $table->integer('comment_id')->index()->default(0);
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

        });
    }
}
