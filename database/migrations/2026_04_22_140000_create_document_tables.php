<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ── Supporting Documents master (HRD defines what docs are required) ──
        Schema::create('supporting_documents', function (Blueprint $table) {
            $table->id();
            $table->string('description');                // e.g. "Surat Lamaran (pdf)"
            $table->string('status', 20)->default('mandatory'); // mandatory | optional
            $table->string('format_file', 10);            // pdf | jpg | png
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });

        // ── Applicant uploaded documents (during Onboarding) ──────────────────
        Schema::create('applicant_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained()->cascadeOnDelete();
            $table->foreignId('supporting_document_id')->constrained()->cascadeOnDelete();
            $table->string('file_path');
            $table->string('original_name')->nullable();
            $table->timestamps();

            $table->unique(['application_id', 'supporting_document_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('applicant_documents');
        Schema::dropIfExists('supporting_documents');
    }
};
