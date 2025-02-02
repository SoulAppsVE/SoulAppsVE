<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->string('reference_no');
            $table->integer('client_id');
            $table->integer('user_id')->nullable();
            $table->string('transaction_type');
            $table->double('discount')->default(0);
            $table->double('total');
            $table->double('labor_cost')->default(0);
            $table->double('paid');
            $table->boolean('return')->default(0);
            $table->timestamps();
            $table->softDeletes();
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
