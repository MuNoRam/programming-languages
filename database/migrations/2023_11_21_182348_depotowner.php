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
        //orders
        Schema::create('orders' , function (Blueprint $table){
            $table->id()->autoIncrement();
            $table->string('pharmacist');
            $table->string('statue');
            $table->boolean('paid');
            $table->float('total_price');
        });

        //ownerinfo
        Schema::create('ownerinfo' , function (Blueprint $table){
            $table->string('username')->rememberToken()->unique();
            $table->string('password')->rememberToken()->unique();
            $table->string('pharmacist');
            $table->int('orderindex')->autoIncrement();

        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
