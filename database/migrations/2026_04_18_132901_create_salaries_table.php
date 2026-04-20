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
    Schema::create('salaries', function (Blueprint $table) {
        $table->id();

        $table->foreignId('employee_id')->constrained()->cascadeOnDelete();
        $table->foreignId('account_id')->constrained()->cascadeOnDelete();

        $table->date('date'); // salary month

        $table->decimal('base_salary', 10, 2); // original salary
        $table->decimal('override', 10, 2)->default(0); // bonus
        $table->decimal('fine', 10, 2)->default(0); // penalty
        $table->decimal('total_salary', 10, 2); // final salary

        $table->timestamps();

        // 🔴 prevent duplicate salary per month
        $table->unique(['employee_id', 'date']);
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salaries');
    }
};
