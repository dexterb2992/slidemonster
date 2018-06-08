<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateSubscriptionPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('subscription_plans', function (Blueprint $table) {
            $table->dropColumn('duration'); //monthly
            
            $table->integer('interval')->default(1); // billing interval
            $table->string('unit')->default('months'); // days, weeks, months, years
            $table->string('unit_text')->default('monthly'); // daily, weekly, every 3 months, every 6 months, yearly
            $table->decimal('price_per_unit', 6,2);
            $table->integer('trial_days')->default(0);

            if (!Schema::hasColumn('subscription_plans', 'created_at')) {
                $table->timestamps();
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('subscription_plans', function (Blueprint $table) {
            $table->string('duration');
            $table->dropColumn('interval');
            $table->dropColumn('unit');
            $table->dropColumn('unit_text');
            $table->dropColumn('price_per_unit');
            $table->dropColumn('trial_days');
        });
    }
}
