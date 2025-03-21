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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_id');
            $table->foreign('invoice_id')->references('invoice_id')->on('invoices')->onDelete('cascade');
            $table->decimal('amount_paid', 10, 2);
            $table->date('payment_date')->default(now());
            $table->enum('currency', ['usd', 'lrd'])->nullable();
            $table->enum('payment_method', ['cash', 'cheque', 'bank transfer', 'credit card', 'debit card', 'deferred', 'mobile money']);
            $table->string('payment_reference')->nullable();
            $table->text('notes')->nullable();
            $table->enum('status', ['uploaded', 'hold', 'pending', 'approved', 'rejected'])->default('uploaded');
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
