<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientBankProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_bank_products', function (Blueprint $table) {
            $table->id()->unsigned();
            $table->string('iban', 28)->unique();
            $table->float('balance')->nullable();
            $table->string('panel_color')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('bank_product_id');
            $table->foreign('bank_product_id')->references('id')->on('bank_products');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('client_bank_products');
    }
}
