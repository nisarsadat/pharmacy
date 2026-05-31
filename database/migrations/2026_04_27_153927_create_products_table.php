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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
        
            $table->string('name');
        
            // قیمت‌ها
            $table->decimal('main_price', 10, 2);
            $table->decimal('sale_price', 10, 2)->nullable();
        
            // مقدار گدام (دانه)
            $table->integer('product_quantity')->default(0);
        
            $table->string('product_company');
        
            // تاریخ‌ها
            $table->date('date')->nullable();
            $table->date('expire_date')->nullable();
            $table->date('produced_date')->nullable();
        
            $table->text('note')->nullable();
        
            // روابط
            $table->foreignId('warehouse_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_type_id')->constrained()->cascadeOnDelete();
        
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
