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
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->enum('role', ['INSTITUSI', 'PESERTA']);
            $table->string('name', 150);
            $table->string('email', 150)->unique();
            $table->string('whatsapp', 20)->nullable();
            $table->string('password');
            $table->enum('institution_type', ['SMK', 'SMA', 'MA', 'UNIVERSITAS', 'POLITEKNIK'])->nullable();
            $table->enum('status', ['pending', 'active', 'rejected', 'inactive'])->default('pending');
            $table->timestamps();
            
            // Indexes
            $table->index('email');
            $table->index('role');
            $table->index('status');
            $table->index(['role', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};
