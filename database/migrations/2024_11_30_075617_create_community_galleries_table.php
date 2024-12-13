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
        Schema::create('community_galleries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ward_id')->nullable()->constrained(
                table: 'inec_wards',
            )->onDelete('cascade');
            $table->string('path');
            $table->integer('width');
            $table->integer('height');
            $table->foreignId('leader_id')->nullable()->constrained(
                table: 'users',
            )->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('community_galleries');
    }
};
