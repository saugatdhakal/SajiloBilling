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
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->enum('account_type',['BUSINESS','INDIVIDUAL']);
            $table->string('name');
            $table->string('shop_name')->nullable();
            $table->string('address')->nullable();
            $table->string('contact_number')->nullable()->unique();
            $table->string('email')->nullable();
            $table->string('vat_number')->nullable()->unique();
            $table->string('pan_number')->nullable()->unique();
            $table->string('remark')->nullable();
            $table->enum('status',['ACTIVE','INACTIVE']);
            $table->softDeletes();
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
        Schema::table('accounts',function(Blueprint $table){
            $table->dropSoftDeletes();
        });
    }
};
