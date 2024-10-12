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
        //
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id'); // Phải là unsignedBigInteger
            $table->unsignedBigInteger('product_id');  // Phải là unsignedBigInteger
            $table->unsignedBigInteger('order_id');    // Phải là unsignedBigInteger
            $table->integer('rating');
            $table->string('phone');
            $table->string('content');
            $table->timestamps();
            // Thiết lập khóa ngoại
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
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
