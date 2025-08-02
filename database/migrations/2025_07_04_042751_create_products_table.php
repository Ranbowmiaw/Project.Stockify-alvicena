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
            $table->string('kode_product');
            $table->integer('category_id');
            $table->integer('supplier_id');
            $table->string('name');
            $table->string('sku');
            $table->text('description');
            $table->decimal('purchase_price',15,0);
            $table->decimal('selling_price',15,0);
            $table->string('image')->nullable();
            $table->integer('minimum_stock');
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
