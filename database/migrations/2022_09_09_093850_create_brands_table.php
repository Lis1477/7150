<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBrandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brands', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('brand_1c_id')->unique();
            $table->string('name');
            $table->string('slug');
            $table->string('image');
            $table->text('content')->nullable();
            $table->string('title')->nullable()->comment('Для метатега title');
            $table->string('keywords')->nullable()->comment('Для метатега keywords');
            $table->string('description', 500)->nullable()->comment('Для метатега description');
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
        Schema::dropIfExists('brands');
    }
}
