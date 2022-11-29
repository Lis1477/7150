<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_1c')->unique();
            $table->integer('category_id_1c')->default(0);
            $table->integer('brand_id_1c')->default(0);
            $table->string('name');
            $table->string('slug');
            $table->string('synonyms')->nullable()->comment('Синонимы для поиска');
            $table->integer('count')->default(0)->comment('Наличие на складе');
            $table->integer('count_type')->default(1)->comment('Тип прайса: 1-стандарт, 2-резерв, 3-скоро');
            $table->string('count_text')->nullable()->comment('Дата прибытия');
            $table->double('price', 8, 2)->default(0)->comment('Розничная цена');
            $table->double('weight', 8, 2)->default(0)->comment('Вес');
            $table->string('keywords')->nullable();
            $table->string('item_description', 500)->nullable()->comment('Краткое описание');
            $table->text('item_set')->nullable()->comment('Комплектация');
            $table->text('item_param')->nullable()->comment('Характеристики');
            $table->text('item_additional')->nullable()->comment('Дополнительные данные');
            $table->string('youtube')->nullable()->comment('Ссылка на ролик');
            $table->string('manual')->nullable()->comment('Ссылка на руководство');
            $table->integer('visite_counter')->default(0)->comment('Количество посещений');
            $table->integer('comment_counter')->default(0)->comment('Количество отзывов');
            $table->double('comment_rate', 5, 2)->default(0)->comment('Рейтинг отзывов %');
            $table->integer('is_action')->default(0)->comment('Если акция - 1');
            $table->date('action_end_date')->nullable()->comment('Дата окончания акции');
            $table->integer('is_new_item')->default(0)->comment('Если новый товар - 1');
            $table->date('date_new_item')->nullable()->comment('Дата окончания новинки');
            $table->double('action_price', 8, 2)->default(0)->comment('Цена по акции');
            $table->integer('for_sale')->default(1)->comment('1-продается, 0-снято с продаж');
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
        Schema::dropIfExists('items');
    }
}
