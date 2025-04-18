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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('description')->nullable();
            $table->text('terms_conditions')->require();
            $table->enum('eligibility', ['individual', 'company', 'both'])->default('Individual');
            $table->decimal('cost', 10, 2);
            $table->enum('currency', ['usd', 'lrd']);
            $table->enum('frequency', ['monthly', 'quarterly', 'half-yearly', 'yearly', 'bi-yearly', 'tri-yearly', 'four-yearly', 'five-yearly']);
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
