<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
    public function up()
{
    Schema::create('products', function (Blueprint $table) {
        $table->id();

        $table->foreignId('warehouse_id')->constrained()->cascadeOnDelete();
        $table->foreignId('product_type_id')->constrained()->cascadeOnDelete();

        $table->string('code')->unique();
        $table->string('name');

        $table->decimal('main_price', 10, 2);
        $table->decimal('sale_price', 10, 2)->nullable();

        $table->integer('main_stock_alert')->default(0);
        $table->date('expire_date_alert')->nullable();

        $table->date('date')->nullable();

        $table->integer('product_amount_carton')->default(0);
        $table->integer('product_amount')->default(0);

        $table->text('note')->nullable();

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
