<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('community_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ward_id')->nullable()->constrained(
                table: 'inec_wards',
            )->onDelete('cascade');
            $table->string('logo')->nullable();
            $table->string('cover_photo')->nullable();
            $table->longText('history')->nullable();
            $table->longText('gallery')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('community_details');
    }
};
