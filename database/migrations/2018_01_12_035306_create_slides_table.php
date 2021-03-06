<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSlidesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slides', function (Blueprint $table) {
            $table->increments('id');
            
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->string('title');
            $table->text('content')->nullable();
            $table->string('type')->comment('adcontent, optin, social');
            $table->float('border_width')->default(0);
            $table->string('border_style', 6)->comment('none, solid, dashed, dotted');
            $table->string('border_color')->nullable();
            $table->string('background_color')->nullable();
            $table->text('background_image')->nullable();

            /* opt-in attributes */
            $table->text('autoresponder_code')->nullable()->comment('opt-in attributes');
            $table->string('name_field')->nullable()->comment('opt-in attributes');
            $table->string('email_field')->nullable()->comment('opt-in attributes');
            $table->text('post_url')->nullable()->comment('opt-in attributes');
            $table->text('hidden_fields')->nullable()->comment('opt-in attributes');
            $table->string('name_label')->nullable()->comment('opt-in attributes');
            $table->string('email_label')->nullable()->comment('opt-in attributes');
            $table->string('button_label')->nullable()->comment('opt-in attributes');
            $table->string('button_color')->nullable()->comment('opt-in attributes');
            $table->string('button_style')->nullable()
                ->comment('opt-in attributes [round, simple, hybrid]');
            $table->string('button_size')->nullable()->comment('optin attributes [small, medium, large]');

            /* social attributes */
            $table->text('twitter')->nullable()->comment('social attributes');
            $table->text('facebook')->nullable()->comment('social attributes');
            $table->text('pinterest')->nullable()->comment('social attributes');
            $table->text('linkedin')->nullable()->comment('social attributes');
            $table->text('youtube')->nullable()->comment('social attributes');
            $table->text('rss')->nullable()->comment('social attributes');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('slides');
    }
}
