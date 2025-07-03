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
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->foreignId('bill_type_id')->nullable()->constrained('bill_types')->nullOnDelete();
            $table->decimal('amount', 10, 2)->nullable(); // bisa dikosongkan dulu
            $table->date('due_date')->nullable();
            $table->unsignedTinyInteger('month')->nullable(); // 1–12 untuk Januari–Desember
            $table->year('year')->nullable();                 // Contoh: 2025
            $table->enum('status', ['unpaid', 'partial', 'paid'])->default('unpaid');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bills');
    }
};
