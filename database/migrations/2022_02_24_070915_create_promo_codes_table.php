<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePromoCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promo_codes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->integer('for_user')->default(0)->comment('0-общий; id юзера-индивидуальный');
            $table->date('end_date')->nullable()->comment('Дата окончания действия');
            $table->double('percent', 5, 2)->default(0)->comment('Процент скидки');
            $table->double('fixed', 8, 2)->default(0)->comment('Фиксированная скидка');
            $table->string('categories', 255)->nullable()->comment('Действует на категории');
            $table->string('items', 255)->nullable()->comment('Действует на товары');
            $table->integer('num_use')->default(1000000)->comment('Количество использований');
            $table->integer('active')->default(1)->comment('0-не активен, 1-активен');
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
        Schema::dropIfExists('promo_codes');
    }
}
