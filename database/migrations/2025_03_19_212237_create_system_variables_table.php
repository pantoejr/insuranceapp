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
        Schema::create('system_variables', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->enum('type', ['name', 'sname', 'email', 'address', 'phone', 'mobile', 'logo']);
            $table->string('value');
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
        Schema::dropIfExists('system_variables');
    }
};
