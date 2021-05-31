<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdditionalColumnsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('name', 'first_name');
            $table->string('last_name', '20');
            $table->string('locale', '3')->default('pl');
            $table->string('street', '30')->nullable();
            $table->string('street_number', '10');
            $table->string('zip', '6');
            $table->string('city', '20');
            $table->string('pesel_number', )->unique();
            $table->date('birth_date');
            $table->integer('status')->default(0);
            $table->bigInteger('voivodeship_id')->unsigned();
        });
        Schema::table('users', function (Blueprint $table) {
            $table->string('first_name', '20')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
