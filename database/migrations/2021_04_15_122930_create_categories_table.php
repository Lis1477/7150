<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_1c')->unique();
            $table->integer('parent_id_1c')->default(0);
            $table->string('name');
            $table->string('image');
            $table->string('thumb_image');
            $table->string('slug');
            $table->string('title')->nullable();
            $table->string('keywords')->nullable();
            $table->string('description', 500)->nullable();
            $table->text('text')->nullable();
            $table->string('order');
            $table->integer('display')->default(1);
            $table->integer('in_header')->default(0)->comment('Если 1, выводится в хэдере');
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
        Schema::dropIfExists('categories');
    }
}
