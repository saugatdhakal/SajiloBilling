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
        Schema::create('configs', function (Blueprint $table) {
            $table->id();
            $table->string('name')->default('Puja fancy Store');
            $table->string('address')->default('itahari');
            $table->string('contact_number')->default('9815320064');
            $table->string('email')->default('pujafancystore1@email.com');
            $table->string('print_notes')->nullable();
            $table->unsignedBigInteger('fiscal_year')->default('7879');
            $table->unsignedBigInteger('sales_bill_number')->default('1');
            $table->unsignedBigInteger('sales_return_bill_number')->default('1');
            $table->unsignedBigInteger('purchase_bill_number')->default('1');
            $table->unsignedBigInteger('purchase_return_bill_number')->default('1');
            // $table->boolean('use_expire_date')->nullable();
            $table->boolean('show_discount')->nullable();
            $table->boolean('show_balance')->nullable();
            $table->boolean('show_mrp')->nullable();
            $table->boolean('use_expenses')->nullable();
            $table->unsignedBigInteger('credit_over_due_warning')->nullable();
            $table->unsignedBigInteger('credit_due_date')->nullable();
            $table->unsignedBigInteger('minimum_stock_warning')->nullable();
            $table->unsignedBigInteger('minimum_stock_info')->nullable();
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
        Schema::dropIfExists('configs');
    }
};
