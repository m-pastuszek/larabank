<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOperationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('operations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('operation_type_id');
            $table->unsignedBigInteger('from_bank_account_id')->nullable();
            $table->unsignedBigInteger('to_bank_account_id')->nullable();
            $table->unsignedBigInteger('transaction_id');
            $table->unsignedBigInteger('status_id');
            $table->timestamps();
            $table->date('scheduled_at');
        });

        Schema::table('operations', function (Blueprint $table) {
            $table->foreign('operation_type_id')->references('id')->on('operation_types');
            $table->foreign('from_bank_account_id')->references('id')->on('client_bank_products');
            $table->foreign('to_bank_account_id')->references('id')->on('client_bank_products');
            $table->foreign('transaction_id')->references('id')->on('transactions');
            $table->foreign('status_id')->references('id')->on('operation_statuses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('operations');
    }
}
