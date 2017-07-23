<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTagsTableAddGoodCat extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('tags') && !Schema::hasColumn('tags', 'good_cat_id')) {
            Schema::table('tags', function (Blueprint $table) {
                $table->integer('good_cat_id');
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
        if (Schema::hasTable('tags') && Schema::hasColumn('tags', 'good_cat_id')) {
            Schema::table('tags', function (Blueprint $table) {
                $table->dropColumn(['good_cat_id']);
            });
        }
    }
}
