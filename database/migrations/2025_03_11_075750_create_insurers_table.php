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
        Schema::create('insurers', function (Blueprint $table) {
            $table->id();
            $table->string('company_name', 150);
            $table->string('registration_number')->nullable(true);
            $table->string('address')->nullable(true);
            $table->string('email');
            $table->string('phone');
            $table->string('key_contact_person')->nullable(true);
            $table->string('key_contact_email')->nullable(true);
            $table->string('description')->nullable(true);
            $table->string('website_url')->nullable(true);
            $table->string('logo')->nullable(true);
            $table->enum('status', ['active', 'inactive'])->default('active');
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
        Schema::dropIfExists('insurers');
    }
};
