<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTimerFontSettingFieldsToSlidesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('slides', function (Blueprint $table) {
            $table->string('timer_label_size')->nullable();
            $table->string('timer_label_color')->nullable();
            $table->string('timer_label_weight')->nullable();
            $table->string('timer_digit_size')->nullable();
            $table->string('timer_digit_color')->nullable();

            $table->string('timer_digit_text_shadow_color')->nullable();
            $table->string('timer_digit_text_shadow_x')->nullable();
            $table->string('timer_digit_text_shadow_y')->nullable();
            $table->string('timer_digit_text_shadow_blur')->nullable();

            $table->string('timer_label_text_shadow_color')->nullable();
            $table->string('timer_label_text_shadow_x')->nullable();
            $table->string('timer_label_text_shadow_y')->nullable();
            $table->string('timer_label_text_shadow_blur')->nullable();
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
            $table->dropColumn('timer_label_size');
            $table->dropColumn('timer_label_color');
            $table->dropColumn('timer_label_weight');
            $table->dropColumn('timer_digit_size');
            $table->dropColumn('timer_digit_color');

            $table->dropColumn('timer_digit_text_shadow_color');
            $table->dropColumn('timer_digit_text_shadow_x');
            $table->dropColumn('timer_digit_text_shadow_y');
            $table->dropColumn('timer_digit_text_shadow_blur');

            $table->dropColumn('timer_label_text_shadow_color');
            $table->dropColumn('timer_label_text_shadow_x');
            $table->dropColumn('timer_label_text_shadow_y');
            $table->dropColumn('timer_label_text_shadow_blur');

        });
    }
}
