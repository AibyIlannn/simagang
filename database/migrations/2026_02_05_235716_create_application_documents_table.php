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
        Schema::create('application_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained('internship_applications')->onDelete('cascade');
            $table->enum('document_type', ['SURAT_PENGAJUAN', 'PROPOSAL', 'REKOMENDASI', 'DAFTAR_PESERTA'])->default('SURAT_PENGAJUAN');
            $table->string('file_path', 255);
            $table->timestamp('created_at')->useCurrent();
            
            // Indexes
            $table->index('application_id');
            $table->index('document_type');
            $table->index(['application_id', 'document_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('application_documents');
    }
};
