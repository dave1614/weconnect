<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paystack_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('event')->nullable();
            $table->string('transaction_id')->nullable();
            $table->string('domain')->nullable();
            $table->string('status')->nullable();
            $table->string('reference')->nullable();
            $table->string('amount')->nullable();
            $table->text('message')->nullable();
            $table->text('gateway_response')->nullable();
            $table->string('paid_at')->nullable();
            $table->string('created')->nullable();
            $table->string('channel')->nullable();
            $table->string('currency')->nullable();
            $table->string('ip_address')->nullable();
            $table->text('metadata')->nullable();
            $table->string('fees_breakdown')->nullable();
            $table->text('log')->nullable();
            $table->string('fees')->nullable();
            $table->string('fees_split')->nullable();
            $table->text('authorization')->nullable();
            $table->text('customer')->nullable();
            $table->text('source')->nullable();
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
        Schema::dropIfExists('paystack_transactions');
    }
};
