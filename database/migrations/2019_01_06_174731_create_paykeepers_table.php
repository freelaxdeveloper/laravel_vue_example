<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaykeepersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paykeepers', function (Blueprint $table) {
            $table->bigIncrements('id');
            // $table->decimal('sum', 8, 2)->comment('Сумма платежа');
            $table->string('clientid')->nullable()->comment('Фамилия Имя Отчество');
            $table->unsignedInteger('orderid')->comment('Номер транзакции');
            $table->integer('ps_id')->nullable()->comment('Идентификатор платежной системы');
            $table->string('service_name')->nullable()->comment('Наименование услуги');
            $table->string('client_email')->nullable()->comment('Адрес электронной почты');
            $table->string('batch_date')->nullable()->comment('Дата списания авторизованного платежа');
            $table->string('client_phone')->nullable()->comment('Телефон');
            $table->string('fop_receipt_key')->nullable()->comment('Код страницы чека 54-ФЗ');
            $table->integer('bank_id')->nullable()->comment('Идентификатор привязки карты');
            $table->string('card_number')->nullable()->comment('Маскированный номер карты');
            $table->string('card_holder')->nullable()->comment('Держатель карты');
            $table->string('card_expiry')->nullable()->comment('Срок действия карты');
            $table->timestamps();

            $table->foreign('orderid')->references('id')->on('transactions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paykeepers');
    }
}
