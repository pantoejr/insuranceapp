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
        Schema::create('policies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('policy_type_id')->constrained()->onDelete('cascade');
            $table->string('number')->unique(true);
            $table->text('description')->nullable(true);
            $table->text('coverage_details')->nullable(true);
            $table->decimal('premium_amount', 10, 2);
            $table->enum('currency', ['usd', 'lrd']);
            $table->enum('premium_frequency', ['monthly', 'quarterly', 'half-yearly', 'yearly']);
            $table->text('terms_conditions')->require();
            $table->enum('eligibility', ['individual', 'company', 'both'])->default('individual');
            $table->enum('status', ['active', 'inactive'])->default('inactive');
            $table->string('created_by')->nullable(true);
            $table->string('updated_by')->nullable(true);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('policies');
    }
};
