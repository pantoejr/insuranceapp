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
        Schema::create('invoices', function (Blueprint $table) {
            $table->string('invoice_id')->primary();
            $table->unsignedBigInteger('invoiceable_id');
            $table->string('invoiceable_type');
            $table->enum('payment_method', ['cash', 'cheque', 'bank transfer', 'credit card', 'debit card', 'deferred', 'mobile money']);
            $table->text('details')->nullable();
            $table->decimal('total_amount', 10, 2);
            $table->enum('currency', ['usd', 'lrd'])->nullable();
            $table->decimal('amount_paid', 10, 2)->default(0);
            $table->decimal('balance', 10, 2);
            $table->date('invoice_date')->default(now());
            $table->date('due_date')->nullable();
            $table->boolean('is_recuring')->default(false);
            $table->boolean('send_reminders')->default(true);
            $table->enum('status', ['Draft', 'Pending', 'Partially-Paid', 'Paid', 'Overdue', 'Cancelled'])->default('Draft');
            $table->text('notes')->nullable();
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
        Schema::dropIfExists('invoices');
    }
};
