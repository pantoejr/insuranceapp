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
        Schema::create('policy_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->onDelete('cascade');
            $table->foreignId('policy_id')->constrained()->onDelete('cascade');
            $table->foreignId('policy_type_id')->nullable()->constrained('policy_types')->onDelete('cascade');
            $table->foreignId('policy_sub_type_id')->nullable()->constrained('policy_sub_types')->onDelete('cascade');
            $table->foreignId('insurer_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->decimal('cost', 10, 2)->default(0);
            $table->enum('currency', ['usd', 'lrd']);
            $table->boolean('is_discounted')->default(false);
            $table->enum('discount_type', ['percentage', 'fixed'])->nullable();
            $table->decimal('discount', 10, 2)->default(0);
            $table->text('notes')->nullable();
            $table->date('policy_duration_start')->nullable();
            $table->date('policy_duration_end')->nullable();
            $table->string('vehicle_make')->nullable();
            $table->string('vehicle_model')->nullable();
            $table->string('vehicle_year')->nullable();
            $table->string('vehicle_VIN')->nullable();
            $table->string('vehicle_reg_number')->nullable();
            $table->enum('vehicle_use_type', ['personal', 'commercial', 'corporate'])->nullable();
            $table->enum('payment_method', ['cash', 'cheque', 'bank transfer', 'credit card', 'debit card', 'deferred', 'mobile money']);
            $table->enum('status', ['draft', 'submitted', 'pending', 'approved', 'rejected', 'completed'])->default('draft');
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('policy_assignments');
    }
};
