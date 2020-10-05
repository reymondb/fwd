<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColLeadBatch extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('lead_batch')) {
            Schema::table('lead_batch', function (Blueprint $table) {
                $table->string('campaign_id')->after('supplier_id')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('lead_batch')) {
            Schema::table('lead_batch', function (Blueprint $table) {
                $table->dropColumn('campaign_id');
            });
        }
    }
}
