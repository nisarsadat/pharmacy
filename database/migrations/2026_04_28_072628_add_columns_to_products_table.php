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
        Schema::table('products', function (Blueprint $table) {
            $table->decimal('main_price_per_carton', 10, 2)->nullable();
            $table->decimal('main_price_per_quantity', 10, 2)->nullable();
            $table->decimal('total_price_per_carton', 10, 2)->nullable();
            $table->decimal('total_price_per_quantity', 10, 2)->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'main_price_per_carton',
                'main_price_per_quantity',
                'total_price_per_carton',
                'total_price_per_quantity'
            ]);
        });
    }
};
