<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id()->unsigned();
            $table->string('title', 140);
            $table->string('recipient_name', 40)->nullable();
            $table->string('recipient_address', 200)->nullable();
            $table->string('recipient_iban', 28)->nullable();
            $table->string('sender_name', 40)->nullable();
            $table->string('sender_address', 200)->nullable();
            $table->string('sender_iban', 28)->nullable();
            $table->float('amount');
            $table->string('currency', 3);
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
        Schema::dropIfExists('transactions');
    }
}
