<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePUserPaymentMethodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p_user_payment_methods', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uid');
            $table->unsignedInteger('user_id');
            $table->string('username')->nullable();
            $table->string('payment_uid',32);

            $table->string('bank_name')->nullable();
            $table->string('bank_account_number')->nullable();
            $table->string('account_opening_branch')->nullable();
            $table->string('transaction_reference')->nullable();

            $table->string('card_number')->nullable();
            $table->string('card_type')->nullable();

            $table->string('mobile_account_number')->nullable();
            $table->tinyInteger('status')->default(1);

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
        Schema::dropIfExists('p_user_payment_methods');
    }
}
