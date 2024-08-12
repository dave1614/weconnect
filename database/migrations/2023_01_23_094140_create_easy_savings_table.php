<?php

use App\Models\SavingsDuration;
use App\Models\SavingsFrequency;
use App\Models\User;
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
        Schema::create('easy_savings', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained()->onDelete('cascade')->nullable();
            $table->decimal('amount',20,2)->default(0.00);
            $table->string('start_date')->nullable();
            $table->foreignIdFor(SavingsFrequency::class)->constrained()->onDelete('cascade')->nullable();
            $table->foreignIdFor(SavingsDuration::class)->constrained()->onDelete('cascade')->nullable();
            $table->string('end_of_savings_date')->nullable();
            $table->string('last_date_debited')->nullable();
            $table->decimal('total_amount_to_be_debited', 20, 2)->default(0.00);
            $table->decimal('total_amount_debited_so_far', 20, 2)->default(0.00);
            $table->boolean('defaulted')->default(false);
            $table->boolean('disbursed')->default(false);            
            $table->decimal('amount_disbursed', 20, 2)->default(0.00);
            $table->string('date_disbursed')->nullable();
            $table->text('cause_of_disbursement')->nullable();
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
        Schema::dropIfExists('easy_savings');
    }
};
