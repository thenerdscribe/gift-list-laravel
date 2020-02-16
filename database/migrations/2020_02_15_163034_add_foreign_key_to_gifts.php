<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyToGifts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('gifts', function (Blueprint $table) {
            $table->bigInteger('receiver_id')->unsigned();
            $table->bigInteger('purchaser_id')->unsigned()->nullable();
            $table->foreign('receiver_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->foreign('purchaser_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('gifts', function (Blueprint $table) {
            $table->dropForeign(['receiver_id']);
            $table->dropForeign(['purchaser_id']);
            $table->dropColumn('purchaser_id');
            $table->dropColumn('receiver_id');
        });
    }
}
