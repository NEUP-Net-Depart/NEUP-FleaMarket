<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('good_info',function(Blueprint $table){
            $table->increments('good_id');
            $table->string('good_name');
            $table->integer('cat_id');
            $table->text('description');
            $table->integer('pricemin');
            $table->integer('pricemax');
            $table->integer('type');
            $table->integer('user_id');
            $table->integer('couts');
            $table->text('good_tag');
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
        Schema::drop('good_info');
    }
}
