<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSlideLayoutChildrenFieldsOnSlidesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('slides', function (Blueprint $table) {
            $table->string('left_col')->after('layout')->nullable();
            $table->string('center_col')->after('left_col')->nullable();
            $table->string('right_col')->after('center_col')->nullable();
            $table->string('one_col')->after('right_col')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('slides', function (Blueprint $table) {
            $table->dropColumn('left_col');
            $table->dropColumn('center_col');
            $table->dropColumn('right_col');
            $table->dropColumn('one_col');
        });
    }
}
