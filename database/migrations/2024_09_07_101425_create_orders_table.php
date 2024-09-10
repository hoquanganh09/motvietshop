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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->string('code')->unique();
            $table->text('address');
            $table->string('fullname');
            $table->string('phone_number', 11);
            $table->string('payment_method');
            $table->integer('status');
            $table->boolean('is_paid')->default(false);
            $table->double('total');
            $table->double('discount')->nullable();
            $table->string('discount_code')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
