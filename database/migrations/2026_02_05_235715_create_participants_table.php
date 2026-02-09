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
        Schema::create('participants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained('internship_applications')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('accounts')->onDelete('set null');
    
            $table->string('name', 150);
            $table->enum('participant_type', ['SISWA', 'MAHASISWA']);
            $table->string('identity_number', 25);
    
            $table->string('major', 100);
            $table->string('class_or_program', 100)->nullable();
            $table->unsignedInteger('semester')->nullable();
    
            $table->string('division', 100);
            $table->string('room', 100);
            $table->unsignedTinyInteger('floor');
    
            $table->enum('status', ['pending', 'active', 'finished', 'rejected'])->default('pending');
    
            $table->timestamps();
    
            $table->index('application_id');
            $table->index('user_id');
            $table->index('status');
            $table->index('identity_number');
            $table->index(['application_id', 'status']);
        });
    
        DB::statement("
            ALTER TABLE participants
            ADD CONSTRAINT chk_participants_floor
            CHECK (floor BETWEEN 1 AND 7)
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('participants');
    }
};
