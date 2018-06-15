<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
