<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('sales', function (Blueprint $table) {
        $table->id();
        $table->text('note')->nullable();
        $table->date('date');
        $table->foreignId('customer_id')->constrained()->cascadeOnDelete();
        $table->foreignId('account_id')->constrained()->cascadeOnDelete();
        // $table->foreignId('user_id')->constrained()->cascadeOnDelete();
        $table->decimal('total_amount', 10, 2);
        $table->decimal('discount', 10, 2)->default(0);
        $table->decimal('final_amount', 10, 2);
        $table->decimal('paid_amount', 10, 2);
        $table->decimal('due_amount', 10, 2);
        $table->string('payment_status');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
