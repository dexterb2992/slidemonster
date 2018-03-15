<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCtaFieldsToSlidesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('slides', function (Blueprint $table) {
            $table->string('types')->nullable()->comment('[adcontent, optin, social]');
            $table->integer('has_cta_button')->default(0);
            $table->string('cta_button_text')->nullable()->comment('text for cta button');
            $table->text('cta_button_url')->nullable()->comment('cta button URL');
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
            $table->dropColumn('types');
            $table->dropColumn('has_cta_button');
            $table->dropColumn('cta_button_text');
            $table->dropColumn('cta_button_url');
        });
    }
}
