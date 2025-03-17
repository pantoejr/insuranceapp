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
        Schema::create('assignment_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('policy_assignment_id')->constrained('policy_assignments')->onDelete('cascade');
            $table->string('document_name');
            $table->string('document_path');
            $table->string('document_type');
            $table->string('created_by');
            $table->string('updated_by');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assignment_documents');
    }
};
