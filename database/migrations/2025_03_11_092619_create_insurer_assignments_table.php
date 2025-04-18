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
        Schema::create('insurer_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('insurer_id')->constrained()->onDelete('cascade');
            $table->string('name', 50);
            $table->string('email', 50);
            $table->string('phone', 20);
            $table->enum('status',['active', 'inactive'])->default('active');
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
        Schema::dropIfExists('insurer_assignments');
    }
};
