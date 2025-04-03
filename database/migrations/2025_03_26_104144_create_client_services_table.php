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
        Schema::create('client_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->constrained('services')->onDelete('cascade');
            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade');
            $table->decimal('cost', 10, 2);
            $table->enum('currency', ['usd', 'lrd']);
            $table->boolean('is_discounted')->default(false);
            $table->enum('discount_type', ['percentage', 'fixed'])->nullable();
            $table->decimal('discount', 10, 2)->default(0);
            $table->text('notes')->nullable();
            $table->date('service_duration_start')->nullable();
            $table->date('service_duration_end')->nullable();
            $table->enum('payment_method', ['cash', 'cheque', 'bank transfer', 'credit card', 'debit card', 'deferred', 'mobile money']);
            $table->enum('status', ['Pending', 'Processing', 'Completed', 'Rejected']);
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
        Schema::dropIfExists('client_services');
    }
};
