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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id');
            $table->string('employee_name');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('position');
            $table->string('address');
            $table->enum('gender', ['male', 'female', 'other']);
            $table->string('profile_picture');
            $table->date('date_of_birth')->nullable();
            $table->enum('status', ['active', 'inactive']);
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
        Schema::dropIfExists('employees');
    }
};
