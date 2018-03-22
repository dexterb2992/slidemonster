<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTimerFieldsToSlidesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('slides', function (Blueprint $table) {
            $table->boolean('has_timer')->default(false);
            $table->string('timer_type')->nullable()->comment('[evergreen, default, red, blue, yellow, green]'); // evergreen,
            $table->string('timer_end')->nullable();
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
            $table->dropColumn('has_timer');
            $table->dropColumn('timer_type');
            $table->dropColumn('timer_end');
        });
    }
}
