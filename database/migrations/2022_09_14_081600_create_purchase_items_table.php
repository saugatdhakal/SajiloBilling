<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_items', function (Blueprint $table) {
            $table->id();
            $table->string('quantity');
            $table->string('rate');
            $table->string('amount');
            $table->string('discount_percent')->default('0');
            $table->string('discount_amount')->default('0');
            $table->string('wholesale_price');
            $table->string('margin_per_item')->default('0');
            $table->string('margin_total')->default('0');
            $table->enum('purchase_item_type',['PURCHASE','RETURN']);
            $table->foreignId('product_id')->constrained();
            $table->foreignId('purchase_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchase_items');
    }
};
