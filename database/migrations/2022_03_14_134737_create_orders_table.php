<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->double('price_total', 8, 2)->comment('Стоимость товара со скидкой');
            $table->double('price_economy', 8, 2)->default(0)->comment('Скидка');
            $table->double('price_delivery', 8, 2)->default(0)->comment('Доставка');
            $table->double('weight', 8, 2)->default(0)->comment('Вес');
            $table->string('client_type', 100);
            $table->string('client_name', 100)->comment('Имя заказчика');
            $table->string('phone', 19);
            $table->string('email', 100);
            $table->string('company_name', 255)->nullable()->comment('Наименование юр.лица');
            $table->string('company_unp')->nullable()->comment('УНП юр.лица');
            $table->text('requisites')->nullable()->comment('Реквизиты юр.лица');
            $table->string('delivery_type', 100)->comment('Тип доставки');
            $table->string('shipping', 50)->nullable()->comment('Вариант доставки');
            $table->string('first_name', 50)->nullable();
            $table->string('second_name', 50)->nullable();
            $table->string('family_name', 50)->nullable();
            $table->string('city', 50)->nullable();
            $table->string('street', 100)->nullable();
            $table->string('house', 10)->nullable();
            $table->string('corpus', 10)->nullable();
            $table->string('flat', 10)->nullable();
            $table->string('entrance', 10)->nullable()->comment('Подъезд');
            $table->string('floor', 10)->nullable()->comment('Этаж');
            $table->string('euro_pv', 255)->nullable()->comment('Пункт выдачи Европочты');
            $table->text('comment')->nullable()->comment('Комментарий');
            $table->string('paying_type', 100)->comment('Тип оплаты');
            $table->string('money_type', 100)->comment('Вариант оплаты');
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
        Schema::dropIfExists('orders');
    }
}
